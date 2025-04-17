<?php
include_once '_partials/_admin_header.php';

?>

<div class="container-fluid">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Enroll Staff</h5>
           

            <div class="container">
                <div id="controls" class="row justify-content-center mx-5 mx-sm-0 mx-lg-5">
                    <div class="col-sm mb-2 ml-sm-5">
                        <button id="createEnrollmentButton" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#createEnrollment" onclick="beginEnrollment()">Create Staff Enrollment</button>
                    </div>
                    
                </div>
            </div>



            
<section>
    <!--Create Enrolment Section-->
    <div class="modal fade" id="createEnrollment" data-backdrop="static" tabindex="-1" aria-labelledby="createEnrollmentTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title my-text my-pri-color" id="createEnrollmentTitle">Create Enrollment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearCapture()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" onsubmit="return false">
                        <div id="enrollmentStatusField" class="text-center">
                            <!--Enrollment Status will be displayed Here-->
                        </div>
                        <div class="form-row mt-3">
                            <div class="col mb-3 mb-md-0 text-center">
                                <label for="enrollReaderSelect" class="my-text7 my-pri-color">Choose Fingerprint Reader</label>
                                <select name="readerSelect" id="enrollReaderSelect" class="form-control" onclick="beginEnrollment()">
                                    <option selected>Select Fingerprint Reader</option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-row mt-2">
                            <div class="col mb-3 mb-md-0 text-center">
                                <label for="userID" class="my-text7 my-pri-color">Specify User to Create</label>
                                <select id="userID" name="userID" class="form-control" required>
                                    <option value="">Select User</option>
                                </select>                            </div>
                        </div>
                        <div class="form-row mt-1">
                            <div class="col text-center">
                                <p class="my-text7 my-pri-color mt-3">Capture Index Finger</p>
                            </div>
                        </div>
                        <div id="indexFingers" class="form-row justify-content-center">
                            <div id="indexfinger1" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="indexfinger2" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="indexfinger3" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="indexfinger4" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                        </div>
                        <div class="form-row mt-1">
                            <div class="col text-center">
                                <p class="my-text7 my-pri-color mt-5">Capture Middle Finger</p>
                            </div>
                        </div>
                        <div id="middleFingers" class="form-row justify-content-center">
                            <div id="middleFinger1" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="middleFinger2" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="middleFinger3" class="col mb-3 mb-md-0 text-center">
                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                            <div id="middleFinger4" class="col mb-3 mb-md-0 text-center" value="true">
                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                            </div>
                        </div>
                        <div class="form-row m-3 mt-md-5 justify-content-center">
                            <div class="col-4">
                                <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1" type="submit" onclick="beginCapture()">Start Capture</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1" type="submit" onclick="serverEnroll()">Enroll</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-secondary btn-outline-warning btn-block my-text-button py-1 border-0" type="button" onclick="clearCapture()">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="form-row">
                        <div class="col">
                            <button class="btn btn-secondary my-text8 btn-outline-danger border-0" type="button" data-dismiss="modal" onclick="clearCapture()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        </div>
    </div>

</div>

<?php
include_once '_partials/_footer.php';

?>