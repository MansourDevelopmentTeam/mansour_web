<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notifications\Notification;
use App\Models\Notifications\PushMessage;
use App\Models\Orders\Order;
use App\Models\Repositories\CustomerRepository;
use App\Models\Services\PushService;
use App\Models\Transformers\CustomerOrderTransformer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class PushMessagesController extends Controller
{
    private $orderTrans;
    private $customerRepo;
    private $pushService;

    public function __construct(CustomerOrderTransformer $orderTrans, CustomerRepository $customerRepo, PushService $pushService)
    {
        $this->orderTrans = $orderTrans;
        $this->customerRepo = $customerRepo;
        $this->pushService = $pushService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = PushMessage::with("creator", "product")->orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", ["messages" => $messages, "total" => PushMessage::count()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required",
            "customer_id" => "nullable|exists:users,id"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $request->merge(["creator_id" => \Auth::id()]);
        $message = PushMessage::create($request->only(["title", "body", "creator_id", "image", "product_id"]));

        // TODO push to queue
        if ($request->customers) {
            $users = User::whereIn('id', $request->customers)->get();
        } else {
            $users = $this->customerRepo->getAllCustomers();
        }
        $notificationsArr = [];
        foreach ($users as $user) {

            $notification = [
                'user_id' => $user->id,
                'title' => $request->title,
                'body' => $request->body,
                'image' => $request->imageUrl,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if($request->has('product_id') && $request->get('product_id') != null){
                $notification['type'] = Notification::TYPE_PRODUCT;
                $notification['item_id'] = $request->get('product_id');
            }else{
                $notification['type'] = Notification::TYPE_GENERAL;
            }

            $notificationsArr[] = $notification;
        }

        foreach (array_chunk($notificationsArr, 1000) as $bulk) {
            Notification::insert($bulk);
        }

        $this->pushService->notifyUsers($users, $message->title, $message->body, $message->image, null, $request->product_id);

        return $this->jsonResponse("Success", $message->load("creator", "product"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = PushMessage::with("creator", "product")->findOrFail($id);

        return $this->jsonResponse("Success", $message);
    }

    public function testPush($id)
    {
        $ps = new PushService;

        $user = User::findOrFail($id);

        $ps->notify($user, "this is title", "this is body");
        // if($user->orders) {
        // }else{
        //     $ps->notify($user, "this is title", "this is body",  $this->orderTrans->transform(Order::first()));
        // }


        return $this->jsonResponse("Success");
    }
}
