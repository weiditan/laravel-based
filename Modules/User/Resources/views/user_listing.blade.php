@extends('layouts.master')

@section('title')
    User Listing
@endsection

@section('content')
    <section class="section">
        <form id="form">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="keyword" class="form-label">Free Text</label>
                    <input type="text" class="form-control" id="keyword" name="keyword"
                           value="{{ request("keyword") }}">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="status" class="form-label">Status</label>
                    {!! Form::select('status', $user_status_dropdown, request("status"), ["class" => "form-control"]) !!}
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" onclick="submitForm('{{ route("user.listing") }}')">Search</button>
                <div class="dropdown">
                    <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="javascript:void(0);"
                               onclick="redirectUrl('{{ route("user.export") }}')">All</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"
                               onclick="submitForm('{{ route("user.export") }}')">Filter</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary" onclick="redirectUrl('{{ route("user.listing") }}')">
                    Reset
                </button>
            </div>
        </form>
    </section>

    <section class="section">
        <div class="d-flex justify-content-end mb-4">
            <a class="ms-auto" href="{{ route("user.add") }}">
                <button type="button" class="btn btn-success">
                    <span class="mdi mdi-plus"></span>
                    Add User
                </button>
            </a>
        </div>

        <table id="table-user" class="table table-hover w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>Profile</th>
                <th>Details</th>
                <th>Status</th>
                <th>Address</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @forelse($user_list as $user)
                <tr class="cursor-pointer"
                    onclick="window.location='{{ route("user.detail", ["user_id" => $user->id]) }}'">
                    <th>{{ $user->id }}</th>
                    <th>
                        @if($user->getFirstDocument("profile_image"))
                            <img class="profile-image-round-70"
                                 src="{{ $user->getFirstDocument("profile_image")->url }}"
                                 alt="{{ $user->getFirstDocument("profile_image")->file_name }}"/>
                        @else
                            <img class="profile-image-round-70"
                                 src="{{ asset('assets/images/profile-placeholder.jpg') }}"
                                 alt="profile-placeholder"/>
                        @endif
                    </th>
                    <td style="min-width: 300px;">
                        <div class="d-flex gap-3">
                            <div>
                                <h6>{{ $user->full_name }}</h6>
                                <p>{{ $user->email }}</p>
                                <p>{{ date_format(date_create($user->birthdate),"d M Y") }}</p>

                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="mt-3 {{ $user_status_color_class_list[$user->status] }}">{{ strtoupper($user->status) }}</h5>
                    </td>
                    <td style="min-width: 300px;">
                        <div class="d-flex flex-column gap-4">
                            @forelse($user->address_list->sortBy('address_type_id') as $address)
                                @if($address->address_type->is_active)
                                    <div>
                                        <h6>{{ $address->address_type->name }}</h6>
                                        <p>{{ "$address->address," }}</p>
                                        <p>{{ "$address->zipcode $address->city," }}</p>
                                        <p>{{ "$address->state, $address->country." }}</p>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </td>
                    <td style="min-width: 230px;">{{ date_format(date_create($user->created_at),"d M Y h:i A") }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No record found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection

@section('script')
    <script type="module">
        $('#table-user').dataTable({
            scrollX: true,
            searching: false
        });
    </script>

    <script>
        function submitForm(url) {
            event.preventDefault();

            const form = document.getElementById("form");
            form.action = url;
            form.submit();
        }

        function redirectUrl(url) {
            event.preventDefault();
            window.location = url;
        }
    </script>
@endsection
