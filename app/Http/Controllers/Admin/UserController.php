<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->returnUrl = "/users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::all();
        return view("backend.users.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view("backend.users.insert_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $user = new User();
        $data = $this->prepare($request, $user->getFillable());
        $user->fill($data);
        $user->save();

        return Redirect::to($this->returnUrl);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(User $user): View
    {
        return view("backend.users.update_form", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, User $user): RedirectResponse
    {
        $data = $this->prepare($request, $user->getFillable());
        $user->fill($data);
        $user->save();

        return Redirect::to($this->returnUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(["message" => "Done", "id" => $user->user_id]);
    }

    /**
     * Show the form for changing password.
     *
     * @return View
     */
    public function passwordForm(User $user): View
    {
        return view("backend.users.password_form", ["user" => $user]);
    }

    /**
     * Updates the specified user's password.
     *
     * @param User $user
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function changePassword(User $user, CategoryRequest $request): RedirectResponse
    {
        $data = $this->prepare($request, $user->getFillable());
        $user->fill($data);
        $user->save();
        return Redirect::to($this->returnUrl);
    }
}
