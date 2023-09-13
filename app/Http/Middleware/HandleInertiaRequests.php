<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            //
            "isLoggedIn" => $this->isLoggedIn(),
            "isAdmin" => $this->isAdmin(),
             "username" => $this->returnUsername(),
             "respondsMsg"=> $this->returnRespondsMsg($request)
        ]);
    }

    //custom function
    private function isLoggedIn(){
        $isloggedIn = false;
 
        if(Auth::check()){
         $isloggedIn = true;
        }
 
        return $isloggedIn;
  } 

  private function returnUsername(){
    $username = "";

    if(Auth::check()){
        $username = Auth::user()->username;
    }

    return $username;
} 
 
private function isAdmin(){
   $isAdmin = false;
 
   if(Auth::check() && Auth::user()->role == 1){
     $isAdmin = true;
   }
 
   return $isAdmin;
 }

 private function returnRespondsMsg($request){
         $respondsMsg = "";
    if ($request->session()->has('respondsMsg')) {
        $respondsMsg = $request->session()->pull('respondsMsg');
        $request->session()->forget('respondsMsg');
      }
  
    return $respondsMsg;
  }

 


}
