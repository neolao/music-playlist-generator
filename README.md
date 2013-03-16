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
| playlistPath | Path of the playlist that will be created | Yes | |
| format | Playlist format | No | m3u8 |
| relativePath | Indicates that the file paths in the playlist are relative | No | false |
| directorySeparator | Directory separator of the file paths in the playlist | No | / |
| rules | Conditions | No | |


Formats
-------

| Format | Status      |
| ------ | ----------- |
| m3u    | Unsupported |
| m3u8   | Available   |
| pls    | In progress |
| xspf   | In progress |
| asx    | In progress |
