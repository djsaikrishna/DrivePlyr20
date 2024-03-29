<?php
session_start();
include '../conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "Not Allowed";
    exit;
}

// Get the video ID from the URL parameter
$id = $_GET['id'];

// Fetch the video information from the database
$sql = "SELECT * FROM videos WHERE id = $id";
$result = $conn->query($sql);

// Check if the video exists
if ($result->num_rows === 0) {
    echo "Video not found";
    exit;
}

// Get the video data
$row = $result->fetch_assoc();
$videoURL = $row['url'];
$videoHosting = $row['hosting'];
$videoTitle = $row['title'];
$videoDescription = $row['description'];
$videoAllowDownload = $row['allow_download'];
$videoPosterURL = $row['poster_url'];
/*print_r($row);
die();*/
?>

<!DOCTYPE html>
<html>
<head>
    <?php
    include 'head.php';
    ?>
    <script>
        function checkVideoURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const videoURL = urlParams.get('url');

            if (videoURL) {
                document.getElementById('input-url').value = videoURL;
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/PrismJS@latest/prism.min.css">
    <script src="https://cdn.jsdelivr.net/gh/CDNSFree2/PrismJS@latest/prism.min.js"></script>
</head>
<body>
<!-- Sidenav -->
<?php include 'nav.php' ?>
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <?php include 'topnav.php' ?>
    <!-- Page content -->
    <div class="container-fluid mt-6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
            <iframe id="iframe" src="https://driveplyr.appspages.online/player.html?id=<?php echo $id ?>&amp;player=plyr" height="600px" width="100%"></iframe>
            </div>
            <div class="col-xl-12 order-xl-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit profile</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="javascript:voide()" onclick="embed()" class="btn btn btn-primary">Embed</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" action="api/update-video.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                            <h6 class="heading-small text-muted mb-6">Video information</h6>
                            <div class="pl-lg-4">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label class="form-control-label" for="code">Embed Code</label>

<pre>
<code id="code" class="language-html">
&#x3C;div id=&#x22;driveplyr<?php echo $id ?>&#x22;&#x3E;&#x3C;/div&#x3E;
&#x3C;script player=&#x22;<span id="plyr">plyr</span>&#x22; src=&#x22;https://driveplyr.appspages.online/player.js&#x22; data-id=&#x22;<?php echo $id ?>&#x22; data-height=&#x22;500px&#x22; data-width=&#x22;100%&#x22; data-type=&#x22;driveplyr&#x22; defer&#x3E;&#x3C;/script&#x3E;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-url" data-toggle="tooltip" data-original-title="Direct Link, Archive.org Link, Google Drive, Mediafire and others">Video URL</label>
                                            <input id="input-url" class="form-control" placeholder="Video URL" name="url" value="<?php echo $videoURL; ?>" type="text" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid video URL.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-hosting">Hosting</label>
                                            <input id="input-hosting" class="form-control" name="hosting" readonly placeholder="Do not edit" value="<?php echo $videoHosting; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-title">Title</label>
                                            <input type="text" id="input-title" class="form-control" placeholder="Title" name="title" value="<?php echo $videoTitle; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-description">Description</label>
                                            <textarea rows="1" class="form-control" placeholder="Description" name="description" required><?php echo $videoDescription; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-allow-download">Allow download</label>
                                            <input type="checkbox" id="input-allow-download" class="form-control" name="allow_download" value="1" <?php if ($videoAllowDownload) echo 'checked'; ?>>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-poster">Poster URL</label>
                                            <input type="text" id="input-poster" class="form-control" placeholder="Poster URL" name="poster_url" value="<?php echo $videoPosterURL; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="player">Player - 
                                                <a target="_blank" rel="nofollow" data-toggle="tooltip" data-original-title="See Example on DrivePlyr Documentation" href="https://driveplyr.hashnode.dev/top-html5-custom-video-players-with-documentation-video">See Examples</a></label>
                                            <select class="form-control" name="player" id="player">
                                              <option value="plyr">Plyr</option>
                                              <option value="sopplayer">SopPlayer</option>
                                              <option value="vlitejs">vLiteJS</option>
                                              <option value="griffith">griffith</option>
                                              <option value="videojs">VideoJS</option>
                                              <option value="jwplayer">JWPlayer</option>
                                              <option value="mediaelements">Mediaelements</option>
                                              <option value="clapper">Clapper</option>
                                              <option value="rainplayer">RainPlayer</option>
                                              <option value="openplayerjs">OpenPlayerJS</option>
                                              <option value="kwgplayer">KWGPlayer</option>
                                              <option value="ckin">Ckin</option>
                                              <option value="cutesu">CuteSu</option>
                                              <option value="xgplayer">XgPlayer</option>
                                              <option value="flowplayer">Flowplayer</option>
                                              <option value="fluid">Fluidplayer</option>
                                              <option value="flamingo">Flamingo</option>
                                              <option value="redroselite">RedRoseLite</option>
                                              <option value="none">NONE</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4"></hr>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include 'footer.php' ?>
    </div>
</div>
<!-- Argon Scripts -->
<!-- Core -->
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/vendor/js-cookie/js.cookie.js"></script>
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
<!-- Argon JS -->
<script src="https://cdn.jsdelivr.net/gh/creativetimofficial/argon-dashboard-bs4@main/assets/js/argon.js?v=1.2.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        checkVideoURL();
    });
    let embed = () => {
      document.getElementById('plyr').innerHTML = document.getElementById('player').value;
      document.getElementById('iframe').src="https://driveplyr.appspages.online/player.html?id=<?php echo $id ?>&player="+document.getElementById('player').value;
    }
</script>
</body>
</html>
