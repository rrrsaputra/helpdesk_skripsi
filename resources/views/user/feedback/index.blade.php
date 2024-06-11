@extends('layouts.user')

@section('content')
    <div class="dx-main">

        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <form action="{{ route('user.feedback.store') }}" method="POST" class="dx-form">
                            <div class="dx-box dx-box-decorated">
                                <div class="dx-box-content">
                                    <h2 class="h6 mb-6">Feedback</h2>
                     
                                </div>
                                <div class="dx-separator"></div>

                                @csrf
                               
                               
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="subject" class="mnt-7">Subject</label>
                                        <input type="text" class="form-control form-control-style-2" id="subject"
                                            placeholder="Enter Subject" name='subject'>
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Message</label>
                                        <textarea class="form-control form-control-style-2" id="message" name="message" rows="5" placeholder="Enter your message"></textarea>
                                    </div>
                                    
                                </div>
                                <button class="dx-btn dx-btn-lg mx-4 float-right my-3" type="submit" name="submit">Submit</button>
                                
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
