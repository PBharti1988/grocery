<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\User;
use App\Restaurant;
use App\Category;
use App\Item;
use App\ItemImage;
use App\ItemDescription;
use App\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

   

    public function category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {
                $res_id = $request->restaurant_id;
                $array=array();
                $check_restaurant =Restaurant::where('id',$res_id)->first();
                if($check_restaurant){
                    $data=Category::where('restaurant_id',$res_id)->whereNull('parent_id')->get();
                    if(count($data) > 0){
                     foreach($data as $val){     

                        $data1=Category::where('restaurant_id',$res_id)->where('parent_id',$val->id)->get();
                        if(count($data1) > 0){
                        $val['sub_category']=$data1;                      
                        foreach($data1 as $val1){
                         $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();                     
                         foreach($items as $val2){
                            $val1['items'] =$items;
                            $images =ItemImage::where('item_id',$val2->id)->get();
                            if(count($images)>0){
                            foreach($images as $val3){
                                $val2['images'] = $images;
                            }
                        }
                            $desc =ItemDescription::where('item_id',$val2->id)->get();
                            if(count($desc)>0){
                            foreach($desc as $val4){
                             $val2['description'] = $desc;
                            }
                        }
                            
                            $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                            if(count($varients)>0){
                            if($varients)
                            {                
                             $val2['varient'] = $varients;
                            }
                        }
                        }
                        }

                    }

                        $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                       if(count($items1) > 0){
                        foreach($items1 as $value){
                            $val['items']=$items1;
                         
                            $images1 =ItemImage::where('item_id',$value->id)->get();
                            if(count($images1)>0){
                            foreach($images1 as $value1){
                                $value['images'] = $images1;
                            }
                        }
            
                            $desc1 =ItemDescription::where('item_id',$value->id)->get();
                            if(count($desc1)>0){
                            foreach($desc1 as $val4){
                             $value['description'] = $desc1;
                            }
                        }
                            
                        
                            $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                            if(count($varients)>0){
                            if($varients)
                            {
                              $value['varient'] = $varients;
                            }
                        }
                        }
                    }

                     }  
                    }
                     
                     if(count($data)>0){
                          $this->response=$data;
                     }else{
                        $this->error_code = -101;
                     }
                   
                }else{
                    $this->error_code = -100;
                }
             
            } catch (\Exception $e) {
                $this->error_code = 500;
                if ($request->debug == true) {
                    $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
                }
            }
        }
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        return response()->json($result);

    }

  

   

}
