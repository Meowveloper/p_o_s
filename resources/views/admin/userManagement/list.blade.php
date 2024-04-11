@extends('admin.layouts.master');



@section('title')
    User List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3 shadow-sm py-2 px-1">
                        <h3>Total Users resulted : <span id="totalOrder" class="text-success">{{ count($users) }}</span>
                        </h3>
                    </div>




                    <div class="table-responsive table-responsive-data2">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (count($users) != 0)
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>User's Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="spacer"></tr>
                                    @foreach ($users as $item)
                                        <tr class="tr-shadow">
                                            <td class="col-2">
                                                @if ($item->image == null)
                                                    <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                                        style="background: none; border-radius: 50%;" class="img-thumbnail">
                                                @else
                                                    <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                                        class="img-thumbnail">
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>
                                                <select class="form-control changeUserRole"
                                                    data-user-id="{{ $item->id }}"
                                                    data-user-name="{{ $item->name }}">
                                                    <option value="user" selected>User</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin#userManagement#goToUserUpdatePage', $item->id) }}" class="w-100 mb-2">
                                                    <button class="btn btn-secondary w-100">Update</button>
                                                </a>
                                                <a href="{{ route('admin#userManagement#deleteUser', $item->id) }}" class="w-100 mb-2">
                                                    <button class="btn btn-danger w-100">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="">
                                There are no users right now. Make more marketing to attrach more users.
                            </div>
                        @endif

                        <div class="mt-5">{{ $users->links() }}</div>
                    </div>


                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
    </div>
@endsection

@section('script_source')
    <script>
        //---------------------------------------
        function d(element) {
            return document.querySelectorAll(element);
        }

        $(document).ready(function() {

            the_whole_page();

            //TODO the whole page
            function the_whole_page() {

                change_user_role();

                //TOOD change user role
                function change_user_role() {

                    d('.changeUserRole').forEach((item) => {

                        item.onchange = () => {

                            const result = window.confirm(
                                `Are you sure you want change the user ${item.dataset.userName} into an admin??`
                                );

                            if (result) {
                                $.ajax({
                                    type: 'get',
                                    url: '/admin/userManagement/changeUserRole',
                                    data: {
                                        userId: item.dataset.userId,
                                        userRole: item.value
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response);
                                        window.location.href =
                                            '/admin/userManagement/listPage';
                                    }
                                });
                            } else {
                                item.value = 'user';
                                return;
                            }



                        }
                    });

                } /* user role change end */


            } /* the whole page end */
        });
    </script>
@endsection


