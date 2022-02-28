@extends('layouts.app')
@section('p_heading')
    Send Message
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-6 mx-auto">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Send</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('send-message') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject</label>
                            <input type="text" class="form-control" id="messageSubject" aria-describedby="messageSubject"
                                placeholder="Enter message subject" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="10" name="message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
