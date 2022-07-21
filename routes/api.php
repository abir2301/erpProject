<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController ;
use  App\Http\Controllers\ClientController;
use  App\Http\Controllers\RoleController ;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


            //Project Routes

            //Paper Routes
            Route::get('/getPaper/{id}',[PaperController::class ,'getPaperById']) ;


            //Contact Routes
            Route::get('/getContact',[ContactController::class , 'getAllContact']) ;
            Route::get('/getContact/{id}',[ContactController ::class,'getContactById']) ;

            //MailContent Routes
            Route::post('/createMailContent','MailContentController@create') ;
            Route::put('/updateMailContent/{id}','MailContentController@update') ;
            Route::get('/getMailContent',[MailContentController::class,'getAllMailContents']) ;
            Route::get('/getMailContent/{id}',[MailContentController::class ,'getMailContentById']) ;
            Route::delete('/deleteMailContent/{id}','MailContentController@delete') ;

            //Type Routes


            // User Routes


//[PatientController::class , 'updatePatient']

            Route::post('/login',    [UserController::class ,'login']) ;
            Route::get('/getUsers/{id}',[UserController::class,'getUserById']) ;
          
 



            //Client Routes

           




            //Role Routes
            Route::get('/getRoles/{id}',[RoleController::class,'getRoleById']) ;//done 




            //Privilege Routes
            Route::post('/createPrivilege','PrivilegeController@create') ;
            Route::put('/updatePrivilege/{id}','PrivilegeController@update') ;
            Route::get('/getPrivileges',[PrivilegeController::class ,'getAllPrivileges']) ;
            Route::get('/getPrivileges/{id}',[PrivilegeController::class,'getPrivilegeById']) ;
            Route::delete('/deletePrivilege/{id}','PrivilegeController@delete') ;//done 





            //Company Routes
            Route::post('/createCompany','CompanyController@create') ;









 

Route::group(['middleware' => 'auth:api'], function () {
   
                        // Manage role by admin
                        Route::post('/createRole','RoleController@create') ;
                        Route::put('/updateRole/{id}','RoleController@update') ;
                        Route::post('/deleteRole','RoleController@delete') ;
                        Route::get('/getRoleprivileges/{id}',[RoleController::class,'getRoleprivileges']) ;
                        Route::get('/getRoles',[RoleController::class,'getAllRoles']) ;
 
 
                        // Manage user
                        Route::post('/createUser','UserController@create') ;//done 
                        Route::get('/getUsers',[UserController::class,'getAllUsers']) ;// get all users  expect admin 
                        Route::post('/deleteUser/{id}','UserController@delete') ;//done 
                        Route::put('/updateUser','UserController@update') ;//done 
                        Route::post('updatePassword','UserController@updatePassword');
                        Route::put('updateUserByAdmin','UserController@updateUserByAdmin') ;// done 
                        Route::get('getConnectedUser',[UserController::class,'getConnectedUser']) ;//done 

                        
                      

                        // Manage Client by admin
                        Route::post('/createClient',[ClientController::class,'create']) ;//done 
                        Route::get('/getClients/{id}',[ClientController::class ,'getClientById']) ;//done 

                        Route::put('/updateClient/{id}','ClientController@update') ;//done 
                        Route::post('/deleteClient','ClientController@delete') ;
                        Route::get('/getClients',[ClientController::class,'getAllclients']) ;//done 
                        Route::get('/getUclients/{id}',[ClientController::class,'getUserClients']) ;
                        Route::get('/ClientsWithProjects', [ClientController::class,'ClientsWithProjects']);
                        Route::get('/projectClient/{id}', [ClientController::class,'projectClient']);
                        Route::get('/getClientContact/{id}', [ClientController::class,'getClientContact']);


                        //Manage Projects by admin
                        Route::post('/createProject','ProjectController@create') ;
                        Route::put('/updateProject','ProjectController@update') ;
                        Route::post('/deleteProject','ProjectController@delete') ;
                        Route::get('/getUserProjects/{id}',[ProjectController::class,'getUserProjects']) ;
                        Route::get('/getProjects',[ProjectController::class ,'getAllProjects']) ;
                        Route::get('getProjectsWithinfo',[ProjectController::class,'getProjectsWithinfo']);
                        Route::get('/getProject/{id}',[ProjectController::class,'getprojectById']) ;



                        Route::get('/paperProject/{id}', 'ProjectController@paperProject');

                        //Create  Bill By admin
                        Route::post('/createBill','BillController@create') ;
                        Route::put('/updateBill/{id}','BillController@update') ;
                        Route::get('/getBill','BillController@getAllBills') ;       
                        Route::post('/deleteBill','BillController@delete') ;
                        Route::get('selectedYear/{selectedYear}',[BillController::class,'selectedYear']) ;
                        Route::get('/getBill/{id}',[BillController::class,'getBillById']) ;
                        Route::post('calcNumBills','BillController@calcNumBills');
                        Route::get('getLastBill',[BillController::class ,'getLastBill']);
                        Route::post('getDateLimits','BillController@getDateLimits');
                        Route::post('BillStatusUpdate','BillController@changeStatus') ;
                         
                         //Create  Quote By admin
                         Route::post('/createQuote','QuoteController@create') ;
                         Route::put('/updateQuote/{id}','QuoteController@update') ;
                         Route::get('/getQuote',[QuoteController::class,'getAllQuotes']) ;
                         Route::post('/deleteQuote','QuoteController@delete') ;
                         Route::get('/getQuote/{id}',[QuoteController::class ,'getQuoteById']) ;
                         Route::post('calcNumQuote','QuoteController@calcNumQuotes');

                        //manage paper by admin
                        Route::post('/createPaper','PaperController@create') ;
                        Route::put('/updatePaper','PaperController@update') ;
                        Route::post('/deletePaper','PaperController@delete') ;
                        Route::get('getTypeofThePaper/{id}',[PaperController::class,'getTypeofThePaper']);
                        Route::post('uploadFile','PaperController@uploadFile');
                        Route::post('SendMailManu','PaperController@SendMailManu');
                        


                        // Get all activity log by admin
                            Route::get('/getAllactivities',[ActivityLogController::class ,'getAllactivities']);
                            Route::get('/getUserActivities/{user_id}',[ActivityLogController::class ,'getUserActivities']);



                        // manage paper type
                            Route::post('/createType','PaperTypeController@create') ;
                            Route::put('/updateType','PaperTypeController@update') ;
                            Route::get('/getPaperTypes',[PaperTypeController::class ,'getAllpaperTypes']) ;
                            Route::get('/getType/{id}',[PaperTypeController::class,'getpaperTypeById']) ;
                            Route::post('/deleteType','PaperTypeController@delete') ;
                            Route::get('/getPapers',[PaperController::class, 'getAllPapers']) ;
                            Route::post('changeStatus','PaperController@changeStatus');
                            Route::get('getPaperofTheType/{id}',[PaperTypeController::class , 'getPaperofTheType']);



                            //Manage contacts by admin
                            Route::post('/createContact','ContactController@create') ;
                            Route::get('/clientWithContacts',[ClientController::class  , 'clientWithContacts']);
                            Route::put('/updateContact','ContactController@update') ;
                            Route::post('/deleteContact','ContactController@delete') ;




                            //Manage Company
                            Route::get('/getCompanyInfo',[CompanyController::class,'getCompanyInfo']) ;
                            Route::put('/updateCompany/{id}','CompanyController@update') ;

                            // manage item
                            Route::post('/createItem','ItemController@create') ;
                            Route::put('/updateItem/{id}','ItemController@update') ;
                            Route::get('/getItems',[ItemController::class,'getAllpaperTypes']) ;
                            Route::get('/getItems/{id}',[ItemController::class,'getpaperTypeById']) ;
                            Route::delete('/deleteItem/{id}','ItemController@delete') ;



                        //Manage actions
                             Route::get('/getActions',[ActionController::class ,'getActions']);


                        // Manage spaces
                             Route::get('/getSpaces',[SpaceController::class,'getSpaces']);


                            // get just contracts
                        Route::get('/getJustContracts',[PaperController::class,'getJustContracts']);


                        // get expired contracts
                        Route::get('/getExpiredContracts',[PaperController::class,'getExpiredContracts']);

                        // sending mail api
                        Route::post('/sendMail1','PaperController@sendMail');





                        //tasks manage
                        
                        Route::get('getTaskByproject/{id}',[TaskController::class,'getTaskByproject']);
                        Route::post('addTask','TaskController@addTask') ; 
                        Route::put('editTask','TaskController@editTask') ; 
                        Route::post('deleteTask','TaskController@deleteTask') ; 
                        Route::post('taskRelation','TaskController@taskRelation') ; 

                        

                            });

                            Route::post('search','UserController@search');
                            Route::post('sendMail','UserController@sendMail');
                            Route::post('resetPassword','UserController@resetPassword');

                            




                               // change password at verification account
                               Route::put('/changePassword','UserController@changePassword') ;
                               Route::post('/checkToken','UserController@checkToken') ;
                               Route::get('/verifMail',[UserController::class,'verifMail']) ;
                               Route::post('/updateEmail','UserController@updateEmail') ;



                               

                               