
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

// Pop the last array item as it has to be formatted differently
$last_item=array_pop($files);

foreach ($files as &$file) {
echo <<< EOT
    {
	"type": "image",
        "url": "$base_url$file",
        "class": "image"
            },
EOT;
	    }
echo <<< EOT
{
	"type": "image",
        "url": "$base_url$last_item",
        "class": "image"
            }
          ]
        }
      ]
    }
  }
}
EOT;
?>