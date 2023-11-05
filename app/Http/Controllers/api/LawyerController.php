<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\User;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Http\Resources\LawyerResource;
use Illuminate\Support\Facades\Validator;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $lawyers = Lawyer::whereHas('specialization', function ($query) {
        // })

        //     ->whereHas('user', function ($query) {
        //     })
        //     ->with('user')
        //     ->whereHas('user.city', function ($query) {
        //     })
        //     ->with('user.city')

        //     ->get();
        // /*

        // $lawyers = Lawyer::join('users','users.id','lawyers.user_id')
        //                    ->join('user_groups','cities.id','users.city_id')
        //                 ->select('lawyers.*','users.name as username','users.email','users.image','users.phone','users.role','cities.name as city_name','specializations.name')
        //                 ->get();


        //  dd($lawyers);


        //$lawyers = Lawyer::with(['user', 'specialization'])->get();



        //   $lawyers = $lawyers->map(function ($lawyer) {
        //       if (is_null($lawyer->specialization)) {
        //           $lawyer->specialization = null;
        //       }
        //       return $lawyer;
        //   });

       //
        $lawyers = Lawyer::whereHas('specialization', function ($query) {
        })

            ->whereHas('user', function ($query) {
            })
            ->with('user')
            ->whereHas('user.city', function ($query) {
            })
            ->with('user.city')
            ->get();
            
        // dd($lawyers);
        return LawyerResource::collection($lawyers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        //Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',  
        ]);
        if($validator->fails())
        {
            return response($validator->errors()->all(), 422);
        }
        $ImageName = $request->file('ImagePath')->getClientOriginalName();
        $request->file('ImagePath')->move(public_path('images/lawyer/'),$ImageName);
        //Create Data
        $data_user = [
            'name' => $request['name'],
            'email' => $request['email'],
            'image' => 'images/universities/'.$ImageName,
            'phone' => $request['phone'],
            'role' => $request['role'],
            'password' => $request['password'],
            'city_id ' => $request['city_id '],
        ];
        */
        // $data_lawyer = [
        //     'price' => $request['price'],
        //     'span' => $request['span'],
        //     'location' => $request['location'],
        //     'about' => $request['about'],
        //     'user_id ' => $request['user_id'],
        // ];

        // //$user   = User::create($data_user);

        $lawyer = Lawyer::create($request->all());

        return (new LawyerResource($lawyer))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //
        $id = $lawyer->id;
        $lawyer = Lawyer::whereHas('user', function ($query) use ($id) {
            $query->where('id', $id);
        })
            ->with('user')
            ->whereHas('user.city', function ($query) {
            })
            ->with('user.city')
            ->whereHas('user.city.country', function ($query) {
            })
            ->with('user.city.country')
            ->get();
        /*
        $lawyer = Lawyer::join('users','users.id','lawyers.user_id')
                        ->join('cities','cities.id','users.city_id')
                        ->join('countries','countries.id','cities.country_id')
                        ->select('lawyers.*','users.name as username','users.email','users.image','users.phone','users.role','cities.name as city_name','countries.name as country_name')
                        ->where('lawyers.id',$lawyer->id)
                        ->get();
*/
        return new LawyerResource($lawyer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
    }

    // public function search(Request $request)
    // {


    //     $specialization = $request->input('specialization');
    //     $city = $request->input('city');
    //     $name_lawyer = $request->input('name_lawyer');

    //     if ($specialization != null && $city != null && $name_lawyer != null) {
    //         $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
    //             $query->where('name', $specialization);
    //         })
    //             ->whereHas('user', function ($query) use ($name_lawyer) {
    //                 $query->where('name', 'LIKE', "%{$name_lawyer}%");
    //             })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) use ($city) {
    //                 $query->where('name', $city);
    //             })
    //             // ->with('user.city')
    //             // ->whereHas('user.city.country', function ($query) {
    //             // })
    //             // ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization != null && $city == null && $name_lawyer == null) {
    //         $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
    //             $query->where('name', $specialization);
    //         })
    //             //  ->with('specialization')
    //             ->whereHas('user', function ($query) {
    //             })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) {
    //             })
    //             // ->with('user.city')
    //             // ->whereHas('user.city.country', function ($query) {
    //             // })
    //             // ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization == null && $city != null && $name_lawyer == null) {
    //         $lawyers = Lawyer::whereHas('user.city', function ($query) use ($city) {
    //             $query->where('name', $city);
    //         })
    //             // ->with('user.city')
    //             // ->whereHas('user.city.country', function ($query) {
    //             // })
    //             // ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization == null && $city == null && $name_lawyer != null) {

    //         $lawyers = Lawyer::whereHas('user', function ($query) use ($name_lawyer) {
    //             $query->where('name', 'LIKE', "%{$name_lawyer}%");
    //         })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) {
    //             })
    //             ->with('user.city')
    //             ->whereHas('user.city.country', function ($query) {
    //             })
    //             ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization == null && $city != null && $name_lawyer != null) {

    //         $lawyers = Lawyer::whereHas('specialization', function ($query) {
    //         })

    //             ->whereHas('user', function ($query) use ($name_lawyer) {
    //                 $query->where('name', 'LIKE', "%{$name_lawyer}%");
    //             })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) use ($city) {
    //                 $query->where('name', $city);
    //             })
    //             ->with('user.city')
    //             ->whereHas('user.city.country', function ($query) {
    //             })
    //             ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization != null && $city == null && $name_lawyer != null) {
    //         $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
    //             $query->where('name', $specialization);
    //         })
    //             ->whereHas('user', function ($query) use ($name_lawyer) {
    //                 $query->where('name', 'LIKE', "%{$name_lawyer}%");
    //             })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) {
    //             })
    //             ->with('user.city')
    //             ->whereHas('user.city.country', function ($query) {
    //             })
    //             ->with('user.city.country')
    //             ->get();
    //     } elseif ($specialization != null && $city != null && $name_lawyer == null) {
    //         $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
    //             $query->where('name', $specialization);
    //         })
    //             ->whereHas('user', function ($query) {
    //             })
    //             ->with('user')
    //             ->whereHas('user.city', function ($query) use ($city) {
    //                 $query->where('name', $city);
    //             })
    //             ->with('user.city')
    //             ->whereHas('user.city.country', function ($query) {
    //             })
    //             ->with('user.city.country')
    //             ->get();
    //     } else {
    //     }

    //     // dd($lawyers);
    //     return LawyerResource::collection($lawyers)->response()->setStatusCode(404);
    // }

    public function search(Request $request)
    {


        $specialization = $request->input('specialization');
        $city = $request->input('city');
        $name_lawyer = $request->input('name_lawyer');

        if ($specialization != null && $city != null && $name_lawyer != null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city == null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                //  ->with('specialization')
                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city != null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('user.city', function ($query) use ($city) {
                $query->where('name', $city);
            })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city == null && $name_lawyer != null) {

            $lawyers = Lawyer::whereHas('user', function ($query) use ($name_lawyer) {
                $query->where('name', 'LIKE', "%{$name_lawyer}%");
            })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city != null && $name_lawyer != null) {

            $lawyers = Lawyer::whereHas('specialization', function ($query) {
            })

                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city == null && $name_lawyer != null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city != null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } else {
            $lawyers = Lawyer::whereHas('specialization', function ($query) {
            })

                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        }

        // dd($lawyers);
        return LawyerResource::collection($lawyers);
    }
}
