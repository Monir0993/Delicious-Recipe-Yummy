<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Validator;
use Mockery\CountValidator\Exception;

class HomeController extends Controller
{
    public function login(){
        if(Auth::guard('web')->check()){
            return redirect('/');
        }else{
            $title = 'Login';
            return view('private.common.recipe.index',compact('title'));
        }
    }
    
    public function authenticate(Request $request){
        $user = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if(Auth::guard('web')->attempt($user)){
            return redirect('/');
        }else{
            session()->flash('alertType','danger');
            session()->flash('acknowledgement','Login Failed: username/password didn\'t matched.');
            return redirect()->back()->withInput();
        }
    }
    
    public function logout(){
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();
            session()->flash('alertType','success');
            session()->flash('acknowledgement','You have been successfully logged out.');
            return redirect('login');
        }else{
            return redirect('/');
        }
    }

    public function registration(){
        if(Auth::guard('web')->check()){
            return redirect('/');
        }else{
            $title = 'Create Account';
            return view('private.common.recipe.registration',compact('title'));
        }
    }

    public function store(Request $request){
        $validation = Validator($request->all(),[
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        if($validation->fails()){
            return Redirect::back()->withErrors($validation)->withInput();
        }
        
        try{
            $input = $request->except('password');
            $input = array_map('trim',$input);
            $user = new User;
            $user->fill($input);
            $user->password = bcrypt($request->password);
            $user->save();

            $data = [
                'username' => $request->username,
                'password' => $request->password
            ];

            if(Auth::guard('web')->attempt($data)){
                return redirect('/');
            }else{
                return redirect('login');
            }
        }catch (Exception $e){
            session()->flash('alertType','danger');
            session()->flash('acknowledgement',$e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function index()
    {
        $title = 'Favourite Food Recipes';
        $favourites = Favourite::whereUserId(Auth::guard('web')->user()->id)->orderBy('id','DESC')->get();
        return view('private.common.recipe.favourites',compact('title','favourites'));
    }
    
    public function addToFavourite(Request $request){
        try{
            Favourite::create($request->all());
            return json_encode([
                'isOK' => true,
            ]);
        }catch (Exception $e){
            return json_encode([
                'isOK' => false,
            ]);
        }
    }
    
    public function deleteFavourite($id){
        try{
            Favourite::whereId($id)->delete();

            $favourites = Favourite::whereUserId(Auth::guard('web')->user()->id)->get();
            return view('private.common.recipe.ajaxFavourites',compact('title','favourites'));
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
}
