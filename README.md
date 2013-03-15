Music playlist generator
========================

Requirement
-----------

PHP CLI >= 5.4


Usage
-----
```bash
./bin/music-playlist-generator.phar configuration.json
```

Configuration
-------------
```json
{
    "exiftoolPath"          : "/path/to/exiftool",
    "mediaDirectoryPath"    : "/path/to/media/library/",
    "playlistPath"          : "./myPlaylist.m3u8",

    "format"                : "m3u8",
    "relativePath"          : true,
    "directorySeparator"    : "/",

    "rules": [
        {
            "field"     : "Popularimeter",
            "operator"  : "isEqual",
            "value"     : 5
        },
        "and",
        [
            {
                "field"     : "Genre",
                "operator"  : "isEqual",
                "value"     : "Pop"
            },
            "or",
            {
                "field"     : "Genre",
                "operator"  : "isEqual",
                "value"     : "Rock"
            }
        ]
    ]
}
```

