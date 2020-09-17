<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Konekt\User\Models\UserProxy;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.home', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return view('account.data', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editData()
    {
        return view('account.edit-data', $this->getCommonParameters());
    }

    protected function getUserDataFromRequest(Request $request)
    {
        $user = auth()->user();

        return $request->validate([
            'name'              => 'required|max:255',
            'surname'           => 'nullable|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|digits:9',
            'newsletter'        => 'boolean',
            'current_password'  => 'password',
            'password'          => 'nullable|confirmed|min:6',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveData(Request $request)
    {
        $userData = $this->getUserDataFromRequest($request);
        $dataToModify = collect($userData)->only(['name', 'surname', 'email', 'phone', 'newsletter'])->toArray();

        if (empty($dataToModify['newsletter'])) {
            $dataToModify['newsletter'] = false;
        }

        $userToUpdate = UserProxy::find(auth()->user()->id);
        if (!empty($userData['password'])) {
            $dataToModify = array_merge(['password'=> Hash::make($userData['password'])], $dataToModify);
        }

        $userToUpdate->update($dataToModify);

        return redirect(route('account.edit-data'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAddressBook()
    {
        return view('account.data', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAddressBook()
    {
        return view('account.data', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveAddressBook()
    {
        return view('account.data', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashAddressBook()
    {
        return view('account.data', $this->getCommonParameters());
    }
}
