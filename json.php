
<?php
$base_url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
//User-defined values
$url = "https://play.google.com/store/books/details/Dmitri_Popov_Tokyo_Taxi_Lights?id=XnwnDwAAQBAJ";
$title = "Tōkyō Taxi Lights";
$description = "Tōkyō Taxi Lights photo book companion app";
$number = 5; // number of photos to display
$ext = "*.jpeg"; // File extension with the wild card

echo <<< EOT
    {
  "\$jason": {
    "head": {
      "title": "$title",
      "description": "$description",
      "actions": {
        "\$pull": {
          "type": "\$reload"
                  }
        },
      "offline": "true",
      "styles": {
       "caption": {
          "font": "Lato",
          "size": "13",
          "align": "center",
          "spacing": "15"
        },
        "image": {
          "width": "100%"
        }
      }
    },
    "body": {
      "header": {
        "title": "$title",
	"style": {
          "font": "Lato",
          "size": "25"
        },
        "menu": {
          "text": "⊚",
          "href": {
            "url": "$url",
            "view": "web"
          },
          "style": {
            "font": "Lato",
            "size": "31"
          }
        }
      },
      "sections": [
        {
	"items": [
EOT;

// Read all files in the directory into the $files array
$files = array();
foreach (glob($ext) as $file) {
  $files[] = $file;
}

// To pick a specified number of random files, shuffle and slice the array
shuffle($files);
$files = array_slice($files, -$number);

// Check whether the last photo has the accompanying text file,
// then read the file's contents into the $end_caption variable.
// If the file doesn't exist, set $end_caption to the file name.
// $end_caption is formatted differently.
$end_txt = pathinfo(end($files), PATHINFO_FILENAME).".txt";
if (file_exists($end_txt)) {
    $end_caption = file_get_contents($end_txt);
    } else {
    $end_caption = pathinfo(end($files), PATHINFO_FILENAME);
    }

foreach ($files as &$file) {

    // Check whether a photo has the accompanying text file,
    // then read the file's contents into the $caption variable.
    // If the file doesn't exist, set $caption to the file name.
    $txt = pathinfo($file, PATHINFO_FILENAME).".txt";
    if (file_exists($txt)) {
        $caption = file_get_contents($txt);
    } else {
        $caption = pathinfo($file, PATHINFO_FILENAME);
    }

echo <<< EOT
    {
	"type": "image",
        "url": "$base_url$file",
        "class": "image"
            },
    {
    "type": "label",
        "text": "$caption",
        "class": "caption"
            },
EOT;
	    }
echo <<< EOT
    {
    "type": "label",
        "text": "🚕",
        "style": {
          "font": "Lato",
          "size": "19",
          "align": "center",
          "spacing": "15"
        }
            }
          ]
        }
      ]
    }
  }
}
EOT;
?>