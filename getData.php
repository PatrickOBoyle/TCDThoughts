<?php
require_once('TwitterAPIExchance.php');

// ensure all variables are set
if(isset( $_POST['lat'] ) &&
  isset( $_POST['long'] ) &&
  isset( $_POST['radius'] )
  ){
    // authentication settings for Twitter API
    $settings = array(
        'oauth_access_token' => "YOUR-KEY-HERE",
        'oauth_access_token_secret' => "YOUR-KEY-HERE",
        'consumer_key' => "YOUR-KEY-HERE",
        'consumer_secret' => "YOUR-KEY-HERE"
    );
    
    // set variables from POST data
    // input validation coming soon(TM)
    $lat = $_POST['lat'];
    $lat = filter_var($lat, FILTER_SANITIZE_NUMBER_FLOAT);
    
    $long = $_POST['long'];
    $long = filter_var($long, FILTER_SANITIZE_NUMBER_FLOAT);
    
    $radius = $_POST['radius'];
    $radius = filter_var($radius, FILTER_SANITIZE_NUMBER_INT);
    
    $unit = $_POST['unit'];
    $radius = $radius . $unit;

    // request url
    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    $requestMethod = 'GET';
    
    // our specific query, set to return 100  tweets (max)
    $getfield = "?geocode=$lat,$long,$radius&count=100";
    
    $request = ($url . $getfield);
    
    // authenticate with twitter api using library
    $twitter = new TwitterAPIExchange($settings);
    
    // make request, save response
    $response = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();
    
}else{
    echo "No user input provided.";
}    
?>

<html>
    <head>
        <!-- JQuery from Google CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <!-- Script from Twitter to display embedded tweets -->
        <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <!-- Mad stylish stuff in here -->
        <link rel="stylesheet" href="./styles.css"/>
        <title>Geo Tweets</title>
    </head>
    <body>
        <header>
            <h2>Top 10 Tweets:</h2>
        </header>
        
        <div id="tweets" class="tweets"></div>
        
        <!-- I'm /still/ a sellout -->
        <footer>
            <p>By <a href="http://patrickoboyle.com">Patrick O'Boyle</a></p>
        </footer>
        
        <!-- Embedded JS with embedded PHP, oh dear...re-design coming soon(TM) -->
        <script type="text/javascript">
            var data = (<?php echo $response ?>).statuses;
            var top10 = data.sort(function(a, b) { return a.favorite_count < b.favorite_count ? 1 : -1; }).slice(0, 10);
            
            $.each(top10, function(data, tweet){
                var profile = "https://twitter.com/" + tweet.user.screen_name + "/status/" + tweet.id_str;
            
                var dataStuff = "<blockquote class='twitter-tweet'><p>" + tweet.text + "&mdash;" + tweet.user.name + " (" + tweet.user.screen_name + ")<a href='" + profile + "' data-datetime='" +  tweet.created_at + "'></a></blockquote>";
                
                $('#tweets').append("<blockquote class='twitter-tweet'><p>" + tweet.text + "&mdash;" + tweet.user.name + " (" + tweet.user.screen_name + ")<a href='" + profile + "' data-datetime='" +  tweet.created_at + "'></a></blockquote>"); 
            });
        </script>
    </body>
</html>