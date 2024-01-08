<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Custom extends Model
{
    public static function settings()
    {
        $data = DB::table('settings');
        if (\Auth::check()) {
            $userId = \Auth::user()->parentId();
            $data = $data->where('parent_id', '=', $userId);
        } else {
            $data = $data->where('parent_id', '=', 1);
        }
        $data = $data->get();
        $settings = [
            "app_name" => "",
            "company_logo" => "logo.png",
            "company_favicon" => "favicon.png",
            "company_currency" => "USD",
            "company_currency_symbol" => "$",
            "company_currency_symbol_position" => "pre",
            "company_date_format" => "M j, Y",
            "company_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_phone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "theme_color"=>"color1",
            "sidebar_mode"=>"light",
            "layout_direction"=>"ltrmode",
            "layout_mode"=>"lightmode",
            "invoice_prefix"=>"#INV-",
            "expense_prefix"=>"#EXP-",
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getValByName($key)
    {
        $setting = Custom::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function setSMTP(array $data)
    {
        $env = app()->environmentFilePath();
        $string = file_get_contents($env);
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                $keyPos = strpos($string, "{$key}=");
                $endLinePos = strpos($string, "\n", $keyPos);
                $oldPos = substr($string, $keyPos, $endLinePos - $keyPos);
                if (!$keyPos || !$endLinePos || !$oldPos) {
                    $string .= "{$key}='{$val}'\n";
                } else {
                    $string = str_replace($oldPos, "{$key}='{$val}'", $string);
                }
            }
        }
        $string = substr($string, 0, -1);
        $string .= "\n";
        if (!file_put_contents($env, $string)) {
            return false;
        }

        return true;
    }

    public static function setPayment(array $data)
    {
        $env = app()->environmentFilePath();
        $string = file_get_contents($env);
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                $keyPos = strpos($string, "{$key}=");
                $endLinePos = strpos($string, "\n", $keyPos);
                $oldPos = substr($string, $keyPos, $endLinePos - $keyPos);
                if (!$keyPos || !$endLinePos || !$oldPos) {
                    $string .= "{$key}='{$val}'\n";
                } else {
                    $string = str_replace($oldPos, "{$key}='{$val}'", $string);
                }
            }
        }
        $string = substr($string, 0, -1);
        $string .= "\n";
        if (!file_put_contents($env, $string)) {
            return false;
        }

        return true;
    }

    public static function setCommon(array $data)
    {
        $env = app()->environmentFilePath();
        $string = file_get_contents($env);
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                $keyPos = strpos($string, "{$key}=");
                $endLinePos = strpos($string, "\n", $keyPos);
                $oldPos = substr($string, $keyPos, $endLinePos - $keyPos);
                if (!$keyPos || !$endLinePos || !$oldPos) {
                    $string .= "{$key}='{$val}'\n";
                } else {
                    $string = str_replace($oldPos, "{$key}='{$val}'", $string);
                }
            }
        }
        $string = substr($string, 0, -1);
        $string .= "\n";
        if (!file_put_contents($env, $string)) {
            return false;
        }

        return true;
    }

    public static function languages()
    {
        $dir = base_path() . '/resources/lang/';
        $glob = glob($dir . "*", GLOB_ONLYDIR);

        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            }, $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            }, $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function dateFormat($settings, $date)
    {
        return date($settings['company_date_format'], strtotime($date));
    }

    public static function priceFormat($settings, $price)
    {

        return $settings['company_currency_symbol'] . $price;
    }

    public static function timeFormat($settings, $time)
    {
        return date($settings['company_time_format'], strtotime($time));
    }

    public static function permissionModules()
    {
        return $modules = [
            'user',
            'role',
            'property',
            'unit',
            'tenant',
            'invoice',
            'invoice type',
            'invoice payment',
            'expense',
            'maintainer',
            'maintenance request',
            'contact',
            'support',
            'note',
            'types',
            'account settings',
            'password settings',
            'general settings',
            'company settings',
           ];
    }

    public function langKeyword(){
        $langKeyword=[
            __('Own Property'),
            __('Lease Property'),
            __('Open'),
            __('Paid'),
            __('Partial Paid'),
            __('Pending'),
            __('In Progress'),
            __('Completed'),
        ];
    }

    public static function invoicePrefix()
    {
        $settings = Custom::settings();
        return $settings["invoice_prefix"];
    }
    public static function expensePrefix()
    {
        $settings = Custom::settings();
        return $settings["expense_prefix"];
    }
}
