Music playlist generator
========================

Requirement
-----------

* PHP CLI >= 5.4
* Perl >= 5


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
    "cachePath"             : "/path/to/cache",

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

| Property | Description | Required | Default value |
| -------- | ----------- | -------- | ------------- |
| exiftoolPath | Path of the exiftool script | No | exiftool |
| cachePath | Path of the cache directory | No | |
| mediaDirectoryPath | Directory containing the medias | Yes | |
| mediaFilePattern | File pattern | No | `*.mp3` |
| playlistPath | Path of the playlist that will be created | Yes | |
| format | Playlist format | No | m3u8 |
| relativePath | Indicates that the file paths in the playlist are relative | No | false |
| directorySeparator | Directory separator of the file paths in the playlist | No | / |
| rules | Conditions | No | |

Note: The paths are relative to the configuration file.


Formats
-------

| Format | Status      |
| ------ | ----------- |
| m3u    | Unsupported |
| m3u8   | Available   |
| pls    | Available   |
| xspf   | Available   |
| asx    | In progress |


Fields
------

| Name                            | Description                   |
| ------------------------------- | ----------------------------- |
| File Name                       | |
| Directory                       | |
| File Size                       | |
| File Modification Date/Time     | |
| File Access Date/Time           | |
| File Inode Change Date/Time     | |
| File Permissions                | |
| File Type                       | |
| MIME Type                       | |
| MPEG Audio Version              | |
| Audio Layer                     | |
| Audio Bitrate                   | |
| Sample Rate                     | |
| Channel Mode                    | |
| MS Stereo                       | |
| Intensity Stereo                | |
| Copyright Flag                  | |
| Original Media                  | |
| Emphasis                        | |
| Album Artist                    | |
| Band                            | |
| Credits                         | |
| Encoded By                      | |
| Performer                       | |
| Www                             | |
| Year                            | |
| Cover Art Front Desc            | |
| ID3 Size                        | |
| Title                           | |
| Artist                          | |
| Album                           | |
| Genre                           | |
| Track                           | |
| Recording Time                  | |
| User Defined URL                | |
| Language                        | |
| Popularimeter                   | |
| Comment                         | |
| Picture Mime Type               | |
| Picture Type                    | |
| Picture Description             | |
| Date/Time Original              | |
| Duration                        | |


Operators
---------

| Operator | Description |
| -------- | ----------- |
| isEqual  | |
| =        | Alias of `isEqual` |
| isDifferent | |
| !=       | Alias of `isDifferent` |
| isHigher | |
| >        | Alias of `isHigher` |
| isHigherOrEqual | |
| >=       | Alias of `isHigherOrEqual` |
| isLower  | |
| <        | Alias of `isLower` |
| isLowerOrEqual | |
| <=       | Alias of `isLowerOrEqual` |
| contains | |

