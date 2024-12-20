<?php

use App\Helpers\AuthHelper;
use App\Models\Health;
use App\Models\Notification;

function removeSession($session)
{
    if (\Session::has($session)) {
        \Session::forget($session);
    }
    return true;
}

function randomString($length, $type = 'token')
{
    if ($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif ($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr(str_shuffle($chars), 0, $length);
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if ($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list, $column_name, $id)
{
    if (count($table_list) > 0) {
        foreach ($table_list as $table) {
            $check_data = \DB::table($table)->where($column_name, $id)->count();
            if ($check_data > 0) return false;
        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model, $file, $name)
{
    if ($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)) {
            foreach ($file as $key => $value) {
                $model->addMedia($value)->toMediaCollection($name);
            }
        } else {
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon', $skip = true)
{
    if (!\Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl = isset($media) ? $media->getPath() : '';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    } else {
        switch ($collection) {
            case 'image_icon':
                $media = asset('images/avatars/01.png');
                break;
            case 'profile_image':
                $media = asset('images/avatars/01.png');
                break;
            default:
                $media = asset('images/common/add.png');
                break;
        }
        return $media;
    }
}

// File exist check
function getFileExistsCheck($media)
{
    $mediaCondition = false;
    if ($media) {
        if ($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function getOpportunityStatusNameById($statusId): string
{
    switch ($statusId) {
        case 1:
            return 'Inquiry';
        case 2:
            return 'Follow Up';
        case 3:
            return 'Stale';
        case 4:
            return 'Completed';
        case 5:
            return 'Failed';
        default:
            return '-';
    }
}

function getOpportunityHealthBadge(int $healthId): string
{
    $health = Health::findOrFail($healthId);

    $statuses = [
        1 => ['badge' => 'success', 'name' => $health->status_health],
        2 => ['badge' => 'warning', 'name' => $health->status_health],
        3 => ['badge' => 'danger', 'name' => $health->status_health],
        4 => ['badge' => 'dark', 'name' => $health->status_health],
    ];

    $status = $statuses[$healthId] ?? ['badge' => 'secondary', 'name' => '-'];

    return '<span class="badge bg-' . $status['badge'] . '">' . $status['name'] . '</span>';
}

function countUnreadNotification(): int
{
    return Notification::where([
        'is_read' => 0,
        'receiver_id' => AuthHelper::authSession()->id,
    ])->count();
}

function getNotification()
{
    return Notification::where('receiver_id', AuthHelper::authSession()->id)
        ->where('is_read', 0)
        ->latest()
        ->take(3)
        ->get();
}

function formatCurrency(int $value)
{
    if ($value >= 1000000000000) {
        return number_format($value / 1000000000000, 2, ',', '.') . 'T';
    } else if ($value >= 1000000000) {
        return number_format($value / 1000000000, 2, ',', '.') . 'M';
    } else if ($value >= 1000000) {
        return number_format($value / 1000000, 2, ',', '.') . 'Jt';
    } else if ($value >= 1000) {
        return number_format($value / 1000, 2, ',', '.') . 'Rb';
    }

    return $value;
}
