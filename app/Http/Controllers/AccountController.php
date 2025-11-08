<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginWithAccountDetails(Request $request, $id)
    {
        $user = \App\Models\User::find($id);

        if (! $user) {
            abort(404, 'User not found');
        }

        // Verify token from main-site
        $expectedToken = hash_hmac('sha256', $id, env('APP_KEY'));

        if (!hash_equals($expectedToken, $request->query('token'))) {
            abort(403, 'Invalid signature.');
        }

        // Log in user
        Auth::login($user);

        return redirect()->route('account.index')->with('success', 'Logged in successfully!');
    }

    public function index(Request $request)
    {
         if ($request->ajax()) {
            $query = Account::where('created_by',Auth::user()->id)->orderBy('id', 'desc');
            return DataTables::of($query)
                ->addColumn('icon', function ($account) {
                    $imagePath = $account->icon 
                        ? asset('storage/' . ltrim($account->icon, '/')) 
                        : asset('assets/images/defaultApp.png');
                    return '<img src="'.$imagePath.'" alt="Icon" class="dataTable-app-img rounded" width="40" height="40">';
                })
                ->addColumn('actions', function ($account) {
                     $buttons = '';
                     $editUrl = route('account.edit', $account->id);
                     $buttons .= '
                            <a href="#" class="btn btn-sm btn-primary me-2" 
                            data-ajax-popup="true" data-size="lg"
                            data-title="Edit Account" data-url="'.$editUrl.'"
                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                <i class="fa fa-edit me-2"></i>Edit
                            </a>
                            ';
                     $deleteUrl = route('account.destroy', $account->id);
                     $buttons .= '
                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                data-url="' . $deleteUrl . '"
                                title="Delete">
                                <i class="fa fa-trash me-2"></i> Delete
                            </button>
                            ';
                       
                    return $buttons;
                })
                ->rawColumns(['icon','actions'])
                ->make(true);
        }
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Account::class],
            'password' => ['required', 'string'],
            'register_email' => ['required', 'string'],
            'register_mobile_no' => ['required', 'string'],
            'authenticator_code' => ['required', 'string'],
            'location' => ['nullable', 'string'],
            'icon'     => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'banner'   => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $path_icon = $request->file('icon')->store('uploads/images/icon', 'public');
        $path_banner = $request->file('banner')->store('uploads/images/banner', 'public');

        $account = new Account();
        $account->name = $request->name;
        $account->email = $request->email;
        $account->password = $request->password;
        $account->register_email = $request->register_email;
        $account->register_mobile_no = $request->register_mobile_no;
        $account->authenticator_code = $request->authenticator_code;
        $account->location = $request->location;
        $account->created_by = Auth::user()->id;
        $account->icon = $path_icon ?? '';
        $account->banner = $path_banner ?? '';
        $account->save();

        return redirect()->route('account.index')->with('success', 'Account created successfully.');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('account.edit', compact('account'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email,' . $account->id,
            'password' => 'nullable|string|min:6',
            'register_email' => 'required|email',
            'register_mobile_no' => 'required|string',
            'authenticator_code' => 'required|string',
            'location' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $data = $request->only(['name', 'email', 'register_email', 'register_mobile_no', 'authenticator_code', 'location']);
        
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        if ($request->hasFile('icon')) {
            if ($account->icon && Storage::disk('public')->exists($account->icon)) {
                Storage::disk('public')->delete($account->icon);
            }
            $data['icon'] = $request->file('icon')->store('uploads/images/icon', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($account->banner && Storage::disk('public')->exists($account->banner)) {
                Storage::disk('public')->delete($account->banner);
            }
            $data['banner'] = $request->file('banner')->store('uploads/images/banner', 'public');
        }
        $account->update($data);
        return redirect()->route('account.index')->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('account.index')->with('success', 'Account deleted successfully.');
    }
}
