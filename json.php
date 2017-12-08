<?php

$base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
$url="https://play.google.com/store/books/details/Dmitri_Popov_Tokyo_Taxi_Lights?id=XnwnDwAAQBAJ";
$title="Tōkyō Taxi Lights";
$description="Tōkyō Taxi Lights photo book companion app";

echo <<< EOT
    {
  "\$jason": {
    "head": {
      "title": "$title",
      "description": "$description",
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
          "font": "Lato Bold",
          "size": "25"
        },
        "menu": {
          "text": "⊚",
          "href": {
            "url": "$url",
            "view": "web"
          },
          "style": {
            "font": "Lato Bold",
            "size": "35"
          }
        }
      },
      "sections": [
        {
	"items": [
EOT;

$files = array();
foreach (glob("*.jpeg") as $file) {
  $files[] = $file;
}

$last_item=array_pop($files);

foreach ($files as &$file) {

if(extension_loaded("exif")) {
	$exif = exif_read_data($file,'EXIF',true);
	$comment=$exif['COMMENT']['0'];
} else {
// $exif = false;
$comment="$file";
}

echo <<< EOT
    {
	"type": "image",
        "url": "$base_url$file",
        "class": "image"
            },
	    {
              "type": "label",
              "text": "$comment",
              "class": "caption"
            },
EOT;
	    }

echo <<< EOT
{
	"type": "image",
        "url": "$base_url$last_item",
        "class": "image"
            },
	    {
              "type": "label",
              "text": "$comment",
              "class": "caption"
            }
          ]
        }
      ]
    }
  }
}
EOT;

?>