@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Broadcasts</h1>
        <p class="mb-4">This table contains all broadcast messages</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Broadcasted Messages</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th width="50%">Message</th>
                                <th>Created By</th>
                                <th>Resent</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($broadcasts as $broadcast)
                                <tr>
                                    <td>{{ $broadcast->subject }}</td>
                                    <td>{{ $broadcast->messages }}</td>
                                    <td>{{ $broadcast->creator->full_name ?? 'N/A' }}</td>
                                    <td>{{ $broadcast->resent }} times</td>
                                    <td>{{ $broadcast->created_at->format('Y-m-d H:m:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-primary dropdown-toggle dropdownbutton" href="#" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Actions link
                                            </a>
                                            <div class="dropdown-menu action" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-item">
                                                    <a class="btn btn-secondary btn-md w-100"
                                                        href="{{ route('resend-message', ['broadcast' => $broadcast]) }}"
                                                        role="button">Resend</a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a class="btn btn-warning btn-md w-100"
                                                        href="{{ route('broadcasts.show', $broadcast) }}"
                                                        role="button">View</a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a class="btn btn-info btn-md w-100"
                                                        href="{{ route('broadcasts.edit', $broadcast) }}"
                                                        role="button">Edit</a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <form action="{{ route('broadcasts.destroy', $broadcast) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger btn-md w-100">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
