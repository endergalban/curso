<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            'skills' => 'array|exists:skills,id',
            'from' => 'date_format:d-m-Y',
            'to' => 'date_format:d-m-Y',
            'order' => 'in:name,email,created_at,name-desc,email-desc,created_at-desc'
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function state($query, $state)
    {
        return $query->where('active', $state == 'active');
    }

    public function skills($query, $skills)
    {
        $subquery = DB::table('user_skill AS s')
            ->selectRaw('COUNT(`s`.`id`)')
            ->whereColumn('s.user_id', 'users.id')
            ->whereIn('skill_id', $skills);
        $query->whereQuery($subquery, count($skills));
    }

    public function from($query, $date)
    {
        $date = Carbon::createFromFormat('d-m-Y', $date);
        $query->whereDate('created_at', '>=', $date);
    }

    public function to($query, $date)
    {
        $date = Carbon::createFromFormat('d-m-Y', $date);
        $query->whereDate('created_at', '<=', $date);
    }
    public function order($query, $value)
    {
        if (Str::endsWith($value, '-desc')) {
            $query->orderByDesc(Str::substr($value, 0, -5));
        } else {
            $query->orderBy($value);
        }
    }



}
