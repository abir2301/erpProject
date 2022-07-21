<?php

namespace App\Http\Controllers;

use App\models\Company;
use Illuminate\Http\Request;
use App\models\ActivityLog;

class CompanyController extends Controller
{
    // add company info by admin
    public function create(Request $request)
    {
        $company = new Company($request->all());
        $company->save();
         return response()->json(["message"=>"Created!","data"=>$company]);
    }




    // update company by admin
    public function update(Request $request,$id)
    {
          $company = Company::find($id);
           $company->update($request->company);
           $company->sendTo = $request->emails ;
           if($request->path){
            $company->logo = $request->path ;
             }

            $company->save();
           return response()->json('updated') ;
          }



        // get company info
        public function getCompanyInfo()
        {
            $company = Company::all() ;
            return response()->json($company);
        }
}

