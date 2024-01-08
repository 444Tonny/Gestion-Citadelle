<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;



    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'type',
        'profile',
        'lang',
        'subscription',
        'subscription_expire_date',
        'parent_id',
        'is_active',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    public function parentId()
    {

        if($this->type == 'admin' || $this->type == 'super admin')
        {
            return $this->id;
        }
        else
        {
            return $this->parent_id;
        }
    }

    public function dateFormat($date)
    {
        $settings = Custom::settings();

        return date($settings['company_date_format'], strtotime($date));
    }

    public function timeFormat($time)
    {
        $settings = Custom::settings();

        return date($settings['company_time_format'], strtotime($time));
    }

    public function priceFormat($price)
    {
        $settings = Custom::settings();

        return $settings['company_currency_symbol'] . $price;
    }

    public function assignSubscription($id)
    {
        $subscription = Subscription::find($id);
        if($subscription)
        {
            $this->subscription = $subscription->id;
            if($subscription->duration == 'month')
            {
                $this->subscription_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($subscription->duration == 'year')
            {
                $this->subscription_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            else
            {
                $this->subscription_expire_date = null;
            }
            $this->save();

            $users = User::where('parent_id', '=', \Auth::user()->parentId())->where('type', '!=', 'super admin')->where('type', '!=', 'admin')->get();
            $propertys = Property::where('parent_id', '=', \Auth::user()->parentId())->get();



            if($subscription->total_user == 0)
            {
                foreach($users as $user)
                {
                    $user->is_active = 1;
                    $user->save();
                }
            }
            else
            {
                $userCount = 0;
                foreach($users as $user)
                {
                    $userCount++;
                    if($userCount <= $subscription->total_user)
                    {
                        $user->is_active = 1;
                        $user->save();
                    }
                    else
                    {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if($subscription->total_property == 0)
            {
                foreach($propertys as $property)
                {
                    $property->is_active = 1;
                    $property->save();
                }
            }
            else
            {
                $propertyCount = 0;
                foreach($propertys as $property)
                {
                    $propertyCount++;
                    if($propertyCount <= $subscription->total_property)
                    {
                        $property->is_active = 1;
                        $property->save();
                    }
                    else
                    {
                        $property->is_active = 0;
                        $property->save();
                    }
                }
            }

        }
        else
        {
            return [
                'is_success' => false,
                'error' => 'Subscription is deleted.',
            ];
        }
    }

    public function totalUser()
    {
        return User::where('type', '!=', 'super admin')->where('type', '!=', 'admin')->where('parent_id', '=', $this->parentId())->count();
    }

    public function totalProperty()
    {
        return Property::where('parent_id', $this->parentId())->count();
    }
    public function totalUnit()
    {
        return PropertyUnit::where('parent_id', $this->parentId())->count();
    }


    public function roleWiseUserCount($role)
    {
        return User::where('type', $role)->where('parent_id',\Auth::user()->parentId())->count();
    }


    public function replacePlaceholders($htmlText)
    {
        $userId = $this->id; // Supposons que l'id de l'utilisateur soit stocké dans la colonne 'id'.

        return preg_replace_callback('/\{([^\}]+)\}/', function ($matches) use ($userId) {
            $attributeName = strtolower(trim($matches[1])); // Convertir en minuscules et supprimer les espaces autour

            // Vérifier si l'attribut existe dans le modèle User
            if ($this->getAttribute($attributeName)) {

                return $this->getAttribute($attributeName) ?: '#NULL#';
            }

            // Si l'attribut n'existe pas, vous pouvez également récupérer des valeurs à partir de relations ou d'autres sources.
            // Par exemple, si vous avez une relation 'profile' sur le modèle User, vous pouvez accéder aux attributs de la relation :
            // if ($this->profile && $this->profile->getAttribute($attributeName)) {
            //     return $this->profile->getAttribute($attributeName);
            // }

            // Si l'attribut n'existe pas, retournez une chaîne vide ou la balise non modifiée
            return '#NULL#';
        }, $htmlText);
    }
}
