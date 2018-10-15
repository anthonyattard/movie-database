<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movie Database!</title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <style type="text/css" media="screen">
        body {
            padding-top: 80px;
            background-color: #4D7CFE;
            color:white;
        }
        #movie-div {
            display: flex;
            flex-flow: row wrap;
        }
        .movie-tile {
            /*border: solid 1px black;*/
            /*background-color: salmon;*/
            color: white;
        }
        h1 {
            margin: 20%;
        }
        .container-fluid {
            padding: 0px;
        }

    </style>
</head>

  <body>


    <script>
        let APIKEY = 'e98b0c6cc173182203c092b09d9debfd';
        let baseURL = 'https://api.themoviedb.org/3/';
        let configData = null;
        let baseImageURL = null;
        
        let runQuery = function (query) {
            $("#movie-div").html("");
            let url = "".concat(baseURL, 'configuration?api_key=', APIKEY);
            fetch(url)
            .then((result)=>{
                return result.json();
            })
            .then((data)=>{
                baseImageURL = data.images.secure_base_url;
                configData = data.images;
                console.log('data:', data);
                runSearch(query)
            })
            .catch(function(err){
                alert(err);
            });
        }
        
        let runSearch = function (keyword) {
            let url = ''.concat(baseURL, 'search/movie?api_key=', APIKEY, '&query=', keyword);
            fetch(url)
            .then(result=>result.json())
            .then((data)=>{
                for(i=0; i < 9; i++) {
                    let the_content = "";
                    let title = data['results'][i]['title'];
                    let release_date = data['results'][i]['release_date'];
                    let overview = data['results'][i]['overview'];

                    // console.log(title + ' ' + release_date + ' ' + overview);

                    the_content += '<div class="col-lg-4 movie-tile text-center" >';
                    the_content += `<h2>${title}</h2>`;
                    the_content += `<h3>${release_date}</h3>`;
                    the_content += `<p>${overview}</p>`;
                    the_content += '</div>';

                    console.log(the_content);

                    $('#movie-div').append(the_content);
                }
            })
        }

        $(document).ready(function() {
            $('#go-btn').click(function() {
                let query = $('#query').val();
                runQuery(query);
            });

            $("#query").on('keyup', function (e) {
                if (e.keyCode == 13) {
                    let query = $('#query').val();
                    runQuery(query);
                }
            });
        });
    </script>

    <!-- Main Page Content -->
    <div class="container">
      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
                <div class="col-lg-6">
                    <a class="navbar-brand" href="#">Movie Database</a>
                </div>

                <div class="col-lg-6" style="margin-top:7px">
                    <div class="input-group">
                      <input id='query' type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button id="go-btn" class="btn btn-default" type="button">Go!</button>
                      </span>
                    </div><!-- /input-group -->
                </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
        <div id="movie-div">
            <h1>Enter a keyword to begin your search</h1>
        </div>
    </div>
  </body>
</html>