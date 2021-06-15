<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>UB Polling</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        <div class="mx-auto" style="width: 50%; text-align: center;">
                <p class="h1" id="s">Seconds left:</p>
                <p class="h2" id="timer"></p>
                <h1 class="m-3">Do you think Jet Fuel can melt steel beams?</h1>
                <button type="button" class="btn btn-outline-danger btn-lg m-2" data-bs-toggle="modal" data-bs-target="#noModal" value="No" onclick=sendPoll(this)>No</button>
                <button type="button" class="btn btn-outline-primary btn-lg m-2" data-bs-toggle="modal" data-bs-target="#tentativeModal" value="Tentative" onclick=sendPoll(this)>Tentative</button>
                <button type="button" class="btn btn-outline-success btn-lg m-2" data-bs-toggle="modal" data-bs-target="#yesModal" value="Yes" onclick=sendPoll(this)>Yes</button>

            <div class="modal fade" id="noModal" tabindex="-1" aria-labelledby="noModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="noModalLabel">Poll submitted!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            <p>Your answer has been recorded: <strong>No</strong></p>
                            <p><small><em>You can change your answer at any time before the timer runs out.</em></small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tentativeModal" tabindex="-1" aria-labelledby="tentativeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tentativeModalLabel">Poll submitted!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            <p>Your answer has been recorded: <strong>Tentative</strong></p>
                            <p><small><em>You can change your answer at any time before the timer runs out.</em></small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="yesModal" tabindex="-1" aria-labelledby="yesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="yesModalLabel">Poll submitted!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            <p>Your answer has been recorded: <strong>Yes</strong></p>
                            <p><small><em>You can change your answer at any time before the timer runs out.</em></small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="main.js" async defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>