<?php

namespace App\Http\Controllers\Admin;

use App\Facade\Settings;
use Illuminate\Http\Request;
use App\Models\Products\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function aramexSubAccount()
    {
        $accounts = config('integrations.aramex.sub_account');

        $sub_accounts = [];
        foreach ($accounts as $key => $account) {
            if ($account['account_number'] != '') {
                $sub_accounts[] = $account;
            }
            unset($sub_accounts[$key]['account_pin']);
        }

        return $this->jsonResponse('success', $sub_accounts);
    }
}
