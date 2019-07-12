<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models;
use Vmorozov\FileUploads\FilesSaver as Uploader;
use Illuminate\Http\UploadedFile;


class User extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $lang;
    protected $lang_id;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
        $this->lang_id = LaravelLocalization::getSupportedLocales()[$this->lang]['id'];
    }

    //DEMO
    public function postUser($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete' || $request->action == 'deactive' || $request->action == 'active') {
				$query = MUser::find($request->id);
                $query_role = RoleUser::where('user_id', $request->id);
				$query_management = SystemManagement::where('user_id', $request->id);
				$old_management = $query_management->get();
				$list_unsub_area = [];
				foreach($old_management as $key => $val){
					if($val->area_id != null || $val->area_id != ''){
						array_push($list_unsub_area, $val->area_id);
					}
					if($val->line_id != null || $val->line_id != ''){
						$list_area = MArea::where('status', 1)->where('line_id', $val->line_id)->pluck('id');
						if(count($list_area) >0){
							foreach($list_area as $key1 => $val1){
								array_push($list_unsub_area, $val1);
							}
						}
					}
				}

                if(!$query) {
                    DB::rollback();
                    return 1;
				}
				
				if(!$query_role) {
					DB::rollback();
					return 1;
				}

				if(!$query_management) {
					DB::rollback();
					return 1;
				}
            }
            $data = [];
            $data_role = [];
            $data_management = [];
			$img_avatar = '';
			
            if($request->has('name') && !empty($request->name)) {
				$data['name'] = $request->name;
			}
			
			if($request->has('phone') && !empty($request->phone)) {
				$data['phone'] = $request->phone;
			}

			if($request->pass == 1) {
            	$default_password = MSetting::first()->default_password;
					$data['password'] = Hash::make($default_password);
			} else {
				if($request->has('password') && !empty($request->password)) {
					$data['password'] = Hash::make($request->password);
				}
			}

			if($request->has('avatar') && !empty($request->avatar)) {
				$dir = public_path('img/avatar');
				if (!File::exists($dir)) {
					File::makeDirectory($dir, 0777, true, true);
				}
				$name_image_avatar = 'avatar_'.time().'.'.$request->avatar->getClientOriginalExtension();
				if($request->action == 'update') {
					$old_file = $query->avatar;
					if(!empty($old_file)){
						@unlink(public_path($old_file));
					}
				}
				$data['avatar'] = 'img/avatar/'.$name_image_avatar;
			} else {
				if($request->fileList == 0) {
					$data['avatar'] = null;
				}
			}

			if($request->has('dob') && !empty($request->dob)) {
				$data['dob'] = Carbon::parse(str_replace('/', '-', $request->dob))->format('Y-m-d');
			}

			if($request->has('role') && !empty($request->role)) {
				array_push($data_role, $request->role);
			}

			if($request->has('role_add') && !empty($request->role_add)) {
				foreach ($request->role_add as $k => $v) {
					array_push($data_role, $v);
				}
			}

			if($request->has('area_id') && !empty($request->area_id)) {
				$data_management['area_id'][] = $request->area_id;
			} else {
				if($request->has('line_id') && !empty($request->line_id)) {
					foreach ($request->line_id as $k => $v) {
						$data_management['line_id'][$k] = $v;
					}
				}
			}
			
			if($request->action == 'update') {
				if (count($data) > 0) {
					$query->update($data);
					if (!$query) {
						DB::rollback();
						return 3;
					}
				}
				if (count($data_role) > 0) {
					$query_role->delete();
					if(!$query_role) {
						DB::rollback();
						return 3;
					}
					foreach ($data_role as $key => $val) {
						$query->attachRole($val);
						if(!$query) {
							DB::rollback();
							return 3;
						}
					}
				}
				if (isset($data_management['area_id'])) {
					$query_management->forceDelete();
					if (!$query_management) {
						DB::rollback();
						return 3;
					}
					$system_management['area_id'] = $data_management['area_id'][0];
					$system_management['line_id'] = null;
					$system_management['user_id'] = $request->id;
					$query_management = SystemManagement::create($system_management);
					if (!$query_management) {
						DB::rollback();
						return 3;
					}
				} else {
					if (isset($data_management['line_id'])) {
						//list area in line
						$list_area = [];
						foreach($data_management['line_id'] as $key => $val){
							$list_area_in_line = MArea::where('status', 1)->where('line_id',$val)->pluck('id');
							if(count($list_area_in_line) > 0){
								foreach($list_area_in_line as $key1 => $val1){
									array_push($list_area, $val1);
								}
							}
						}
						$list_area = array_unique($list_area);
						$query_management->forceDelete();
						if(!$query_management) {
							DB::rollback();
							return 3;
						}
						foreach ($data_management['line_id'] as $key => $val) {
							$system_management['line_id'] = $val;
							$system_management['user_id'] = $request->id;
							$system_management['area_id'] = null;
							$query_management = SystemManagement::create($system_management);
							if(!$query_management) {
								DB::rollback();
								return 3;
							}
						}
					} else {
						$query_management->forceDelete();
						if(!$query_management) {
							DB::rollback();
							return 3;
						}
					}
				}
			} else if($request->action == 'delete') {
					$img_avatar = $query->avatar;
					$noti = MNotification::where('user_id', $request->id);
					if(count($noti->get()) > 0) {
						DB::rollback();
						return 4;
					}
					$to = MNotification::where('to', $request->id);
					if(count($to->get()) > 0) {
						DB::rollback();
						return 4;
					}
					$query_role->delete();
					if(!$query_role) {
						DB::rollback();
						return 5;
					}
					$query_management->forceDelete();
					if(!$query_management) {
						DB::rollback();
						return 5;
					}
					$query->delete();
					if(!$query) {
						DB::rollback();
						return 5;
					}
			} else if($request->action == 'deactive') {
				$query->update(['status' => 0]);
				if(!$query) {
					DB::rollback();
					return 5;
				}
			}  else if($request->action == 'active') {
				$query->update(['status' => 1]);
				if(!$query) {
					DB::rollback();
					return 5;
				}
			} else {
					$query = MUser::create($data);
					foreach ($data_role as $key => $val) {
						$query->attachRole($val);
						if(!$query) {
							DB::rollback();
							return 6;
						}
					}

					if (isset($data_management['area_id'])) {
						$system_management['area_id'] = $data_management['area_id'][0];
						$system_management['line_id'] = null;
						$system_management['user_id'] = $query->id;
						$query_management = SystemManagement::create($system_management);
						if (!$query_management) {
							DB::rollback();
							return 6;
						}
					} else {
						if (isset($data_management['line_id'])) {
							foreach ($data_management['line_id'] as $key => $val) {
								$system_management['line_id'] = $val;
								$system_management['area_id'] = null;
								$system_management['user_id'] = $query->id;
								$query_management = SystemManagement::create($system_management);
								if(!$query_management) {
									DB::rollback();
									return 6;
								}
							}
						}
					}
					if(!$query) {
						DB::rollback();
						return 6;
					}
			}

				if ($query) {
					if(!empty($img_avatar)){
						@unlink(public_path($img_avatar));
					}
					
					DB::commit();
					if($query->fcm_token != null || $query->fcm_token != ''){
						if($request->action == 'update' || $request->action == 'delete' || $request->action == 'deactive') {
							// //Expire token
							if($query->user_token != '' || $query->user_token != null){
								$this->blacklist($query->user_token);
							}
							if(count($list_unsub_area)>0){
								foreach($list_unsub_area as $key => $val){
									UnSubscribeTopic::dispatch($query->fcm_token, 'group_'.$val);
									// self::UnSubscribeTopic($query->fcm_token, 'group_'.$val);
								}
							}
						}
						if($request->action == 'update') {
							if(isset($data_management['area_id'])) {
								SubscribeTopic::dispatch($query->fcm_token, 'group_'.$data_management['area_id'][0]);
								// self::SubscribeTopic($query->fcm_token, 'group_'.$data_management['area_id'][0]);
							}
							if (isset($data_management['line_id'])) {
								if(count($list_area) >0){
									foreach($list_area as $list => $item){
										SubscribeTopic::dispatch($query->fcm_token, 'group_'.$item);
										// self::SubscribeTopic($query->fcm_token, 'group_'.$item);
									}
								}
							}
						} 
					}
					if($request->has('avatar') && !empty($request->avatar)) {
						Uploader::uploadFile($request->avatar,'img/avatar' , 'avatar', false, $name_image_avatar);
					}
					return true;
				} else {
					DB::rollback();
					return 7;
				}
			} catch (\Exception $e) {
				DB::rollback();
				return 7;
			}
    }
    
    public function getUser($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MUser::with('role_users.role')->where('id', '!=', 1)->where('id', $id);
			$user = $data->first();
            if (!empty($user)) {
                return self::JsonExport(200, trans('app.success'), $user);
            } else {
                return self::JsonExport(404, trans('app.error_404'));
            }
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }

    public function getDTUser($request)
    {
		
        self::__construct();
        try {
			if(isset($request) && $request != ''){
				$data =  Models\MUser::with('role_users.role','m_major.m_major_translation')->where('major_id', $request)->where('id', '!=', 1);
			} else {
				$data =  Models\MUser::with('role_users.role')->where('id', '!=', 1);
			}
			return Datatables::of($data)
			->editColumn('name', function ($v) {
					if(!empty($v->name)) {
						return $v->name;
					} else {
						return '';
					}
			})
			->filterColumn('name', function ($data, $keyword) {
				$data->where('name', 'LIKE', '%'.$keyword.'%');
			})
			->editColumn('email', function ($v) {
				if(!empty($v->email)) {
					return $v->email;
				} else {
					return '';
				}
			})
			->editColumn('major', function ($v) {
				if(!empty($v->major_id)) {
					return $v->m_major->m_major_translations->name;
				} else {
					return '';
				}
			})
			->editColumn('phone', function ($v) {
				if(!empty($v->phone)) {
					return $v->phone;
				} else {
					return '';
				}
			})
			->editColumn('role', function ($v) {
				if(count($v->role_users) > 0){
					return $v->role_users[0]->role->name;
				} else {
					return '';
				}
				
			})
			->addColumn('action', function ($v) {
				$action = '';
				if(1==1) {
					$action .= '<span class="btn-action table-action-edit cursor-pointer tx-success" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-edit"></i></span>';
				}
				
				if(1==1) {
					if($v->status == 1) {
						$action .=  '<span class="btn-action table-action-deactive cursor-pointer tx-warning mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="icon ion-locked"></i></span>';
					} else {
						$action .=  '<span class="btn-action table-action-active cursor-pointer tx-info mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="icon ion-unlocked"></i></span>';
					}
				}
				
				if(1==1) {
					$action .=  '<span class="btn-action table-action-delete cursor-pointer tx-danger mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-trash"></i></span>';
				}

				return $action;
			})
			->addIndexColumn()
			->rawColumns(['action', 'role', 'email', 'major'])
			->make(true);
        } catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
        }
    }
	
		public function getDTUserActivities($id)
		{
			self::__construct();
			try {
				$data = ActivityLog::where('causer_id', $id);
				return Datatables::of($data)
					->editColumn('created_at', function ($v) {
						return $v->created_at;
					})
					->editColumn('causer_type', function ($v) {
						return $v->causer_type;
					})
					->editColumn('description', function ($v) {
						return $v->description;
					})
					->editColumn('status', function ($v) {
						$status = json_decode($v->properties, true);
						return $status['status'];
					})
					->addIndexColumn()
					->make(true);
			} catch (\Exception $e) {
				return self::JsonExport(500, trans('app.error_500'));
			}
		}
	//DEMO
	
	public function blacklist($token)
    {
        try {
            $check = Storage::disk('local')->exists(md5($token));
            if(!$check) {
                Storage::disk('blacklist')->put(md5($token), 'Blocked');
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
