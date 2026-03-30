<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class LogReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'type_id', 'message', 'context',
        'user_id', 'ip_address', 'url', 'method', 'logged_at', 'changes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addLog($data) {

        try {
            // echo "<pre>";
            //     print_r($data);exit;
            // $model = new self();
            // $model->type = $data["type"] ?? "";
            // $model->type_id = $data["type_id"] ?? 0;
            // $model->message = $data["message"] ?? "";
            // $model->user_id = $data["user_id"];
            // $model->ip_address = $data["ip_address"] ?? "";
            // $model->url = $data["url"] ?? "";
            // $model->method = $data["method"] ?? "";
            // $model->changes = $data["changes"] ? json_encode($data["changes"], JSON_UNESCAPED_UNICODE)  : "";
            DB::table('log_reports')->insert($data);
        } catch (\Throwable $th) {
            return false;
        }

    }
}
