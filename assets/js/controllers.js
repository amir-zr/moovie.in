var addMovie = myApp.controller("addMovie", function ($rootScope, $scope, httpService) {

    $scope.faname;
    $scope.enname;
    $scope.desc = '🎥نام فیلم : \n' +
        '🎭ژانر : \n' +
        '👤کارگردان : \n' +
        '👥بازیگران : \n' +
        '🏳محصول : \n' +
        'زبان : انگلیسی با #زیرنویس_پلیر\n' +
        '🎖امتیاز : \n' +
        'خلاصه داستان : ';
    $scope.myQuality = ["1080p", "720p", "480p"];
    $scope.trailer;
    $scope.points;
    $scope.genre;

    //For player
    $scope.playerLinks = [];
    $scope.playerVideoLevel = 1;
    $scope.playerVideoQuality = $scope.myQuality[0];
    $scope.playerVideoLink = "";
    $scope.playerVideoFileId = "";
    $scope.playerVideoDesc = "🔸دوبله فارسی";

    //For file
    $scope.fileLinks = [];
    $scope.fileVideoLevel = 1;
    $scope.fileVideoQuality = $scope.myQuality[0];
    $scope.fileVideoLink = "";
    $scope.fileVideoFileId = "";
    $scope.fileVideoDesc = "🔸دوبله فارسی";


    function isSetVariable(value) {
        console.log(value);
        if (typeof value !== 'undefined' && value.length >= 1) {
            return true;
        }
        return false;
    }



    $scope.addLink = function () {
        var videoArray = [$("#playerVideoLevel").val(), $("#playerVideoQuality").val(), $scope.playerVideoLink];
        var linkComplete = videoArray.every(isSetVariable);
        console.log(linkComplete);
        if (linkComplete === true) {
            console.log("Complete");
            var thisLink = {
                "playerLevel": $("#playerVideoLevel").val(),
                "playerQuality": $("#playerVideoQuality").val(),
                "playerLink": $scope.playerVideoLink,
                "playerFileId": $scope.playerVideoFileId,
                "playerDesc": $scope.playerVideoDesc
            };
            $scope.playerLinks.push(thisLink);

            console.log($scope.playerLinks);
            //reset
            $scope.playerVideoLevel++;
            $("#playerVideoLevel").val($scope.playerVideoLevel);
            $scope.playerVideoQuality = $scope.myQuality[$scope.playerVideoLevel - 1];
            $("#playerVideoQuality").val($scope.playerVideoQuality);
            $scope.playerVideoLink = "";
            $scope.playerVideoFileId = "";
            $scope.playerVideoDesc = "🔸دوبله فارسی\\n🔸بدون سانسور";
        }
    };

    $scope.deleteLink = function (index) {
        //console.log(index);
        $scope.playerLinks.splice(index, 1);
        //console.log($scope.playerLinks)
    };

    $scope.sendMovie = function () {
        console.log("Click sendMovie");

        if (document.getElementById("cover-input").files.length >= 1) {
            var cover = document.getElementById("cover-input").files[0];
            if (document.getElementById("subtitleSrt-input").files.length >= 1) {
                var subtitleSrt = document.getElementById("subtitleSrt-input").files[0];
            }
            /* console.log($scope.faname);
             console.log($scope.enname);
             console.log($scope.desc);
             console.log($scope.trailer);*/

            var fullMovieArray = [$scope.faname, $scope.enname, $scope.points, $scope.genre, $scope.desc];
            var linkComplete2 = fullMovieArray.every(isSetVariable);
            if (linkComplete2 === true) {
                console.log("all var is complete!!");
                var formData = new FormData();
                formData.append("cover", cover);
                if (document.getElementById("subtitleSrt-input").files.length >= 1) {
                    formData.append("subtitleSrt", subtitleSrt);
                }
                formData.append("faname", $scope.faname);
                formData.append("enname", $scope.enname);
                formData.append("points", $scope.points);
                formData.append("genre", $scope.genre);
                formData.append("desc", $scope.desc);
                formData.append("links", JSON.stringify($scope.playerLinks));
                formData.append("trailer", $scope.trailer);

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };
                sendAddMovieRequest(formData, config);

            }

        }


    };

    $scope.sendMovieToAdmin = function (admin, movie) {
        console.log(admin, movie);
        const config = "";

        var channel = $('input[data-movie-id=' + movie + ']:checked').val();

        var param = {
            "admin": admin,
            "movie": movie,
            "channel": channel
        };
        //console.log(channel);
        sendMovieToAdminRequest(param, config);

    };

    function sendAddMovieRequest(params, config) {
        console.log("SEND Req!!");
        $(".loading").css("display", "inline-block");
        $(".btn-add").attr("disabled", "disabled");
        httpService.post("https://moovie.in/proc/add-movie.php", params, config).then(function (response) {
            if (response.data == "1") {
                alert("Added Successfully.");
                $(".loading").css("display", "none");
                $(".btn-add").removeAttr("disabled");
            } else {
                alert("Added Failed!!!");
                $(".loading").css("display", "none");
                $(".btn-add").removeAttr("disabled");
            }
        }).catch(function (reason) {
            alert("Added Failed!!!");
            $(".loading").css("display", "none");
            $(".btn-add").removeAttr("disabled");
        })

    }

    function sendMovieToAdminRequest(params, config) {
        console.log("SEND Req!!");
        httpService.get("https://moovie.in/proc/send-movie-to-admin.php", params, config).then(function (response) {
            if (response.data == "1") {
                alert("Send Successfully.");
            } else {
                alert("Send Failed!!!");
            }
        }).catch(function (reason) {
            alert("Send Failed!!!");
        })
    }


});