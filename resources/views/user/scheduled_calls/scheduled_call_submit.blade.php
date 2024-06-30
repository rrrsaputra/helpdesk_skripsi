@extends('layouts.user')

@section('content')
    <div class="dx-main">

        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <form action="{{ route('user.scheduled-ticket.store') }}" method="POST" class="dx-form">
                            <div class="dx-box dx-box-decorated">
                                <div class="dx-box-content">
                                    <h2 class="h6 mb-6">Scheduled a Call</h2>
                                    <!-- START: Breadcrumbs -->
                                    <nav aria-label="breadcrumb">
                                        <uo class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('scheduled_call.index') }}">Scheduled Calls</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Book Scheduled Call</li>
                                        </ol>
                                    </nav>
                                    <!-- END: Breadcrumbs -->
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="date" class="mnt-7">Choose Date</label>
                                        <input type="date" class="form-control form-control-style-2" id="date" name="date" min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="time" class="mnt-7">Choose Time</label>
                                        <select class="form-control form-control-style-2" id="time" name="time">
                                            <option value="09:00">09:00 AM</option>
                                            <option value="09:30">09:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="12:30">12:30 PM</option>
                                            <option value="13:00">01:00 PM</option>
                                            <option value="13:30">01:30 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="14:30">02:30 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="15:30">03:30 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                            <option value="16:30">04:30 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="duration" class="mnt-7">Choose Duration</label>
                                        <select class="form-control form-control-style-2" id="duration" name="duration">
                                            <option value="30">30 minutes</option>
                                            <option value="45">45 minutes</option>
                                            <option value="60">60 minutes</option>
                                            <option value="90">90 minutes</option>
                                        </select>
                                    </div>

                                </div>
                                @csrf
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="category" class="mnt-7">Category</label>
                                        <input type="text" class="form-control form-control-style-2" id="category"
                                            placeholder="Enter Category" name='category'>
                                    </div>
                                </div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="subject" class="mnt-7">Subject</label>
                                        <input type="text" class="form-control form-control-style-2" id="subject"
                                            placeholder="Enter Subject" name='title'>
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Message</label>
                                        <div class="dx-editors" data-editor-height="150" data-editor-maxheight="250"
                                            style="min-height: 150px; max-height: 250px;">
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var quill = new Quill('.dx-editors', {
                                                    theme: 'snow'
                                                });

                                                quill.on('text-change', function() {
                                                    var message = document.querySelector('input[name=message]');
                                                    message.value = quill.root.innerHTML;
                                                });
                                            });
                                        </script>
                                        <input type="hidden" name="message" id="message">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-0">


                                <div class="row justify-content-between vertical-gap dx-dropzone-attachment">
                                    <div class="col-auto dx-dropzone-attachment-add">

                                    </div>
                                    <div class="col-auto dx-dropzone-attachment-btn ">
                                        <button class="dx-btn dx-btn-lg" type="submit" name="submit">Submit</button>
                                    </div>
                                </div>
                                <!-- END: Dropzone -->

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
