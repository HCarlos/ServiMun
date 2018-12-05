@extends('home')

@section('container')

    @catalogo
    @slot('buttons')
        @include('shared.ui_kit.__menu_catalogo')
    @endslot
    @slot('body_catalogo')
        <div class="col-md-12">

            <div class="table-responsive-sm">
                <table class="table table-striped table-centered mb-0">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Account No.</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="table-user">
                            <img src="assets/images/users/avatar-2.jpg" alt="table-user" class="mr-2 rounded-circle">
                            Risa D. Pearson
                        </td>
                        <td>AC336 508 2157</td>
                        <td>July 24, 1950</td>
                        <td class="table-action">
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-user">
                            <img src="assets/images/users/avatar-3.jpg" alt="table-user" class="mr-2 rounded-circle">
                            Ann C. Thompson
                        </td>
                        <td>SB646 473 2057</td>
                        <td>January 25, 1959</td>
                        <td class="table-action">
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-user">
                            <img src="assets/images/users/avatar-4.jpg" alt="table-user" class="mr-2 rounded-circle">
                            Paul J. Friend
                        </td>
                        <td>DL281 308 0793</td>
                        <td>September 1, 1939</td>
                        <td class="table-action">
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-user">
                            <img src="assets/images/users/avatar-5.jpg" alt="table-user" class="mr-2 rounded-circle">
                            Sean C. Nguyen
                        </td>
                        <td>CA269 714 6825</td>
                        <td>February 5, 1994</td>
                        <td class="table-action">
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div> <!-- end table-responsive-->
        </div>
    @endslot
    @endcatalogo

@endsection
