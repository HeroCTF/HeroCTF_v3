# HeroRPG

### Category

Misc

### Description

This RPG game wasn't well designed, and I am pretty sure there is no way to win... Or is it ?

To run the game, go to the `Hero/www` folder and run `sudo python3 -m http.server 80`. The game is available through your browser : `http://localhost:80`

You can move around with the arrow keys, interact with enter, and open your inventory with X.

Format : **HERO{flag}**<br>
Author : **Log_s**

### Write up

There are many ways to solve this challenge. I am gonna present two of them in this write-up.

First, let's understand what the goal is, and what the scenario allows us to do.

We probably have to get passed the keeper, who is asking for a golden perl to give you access to the "sacred Flag Lands". There is a chest giving you these gold perls, but anytime you approach the keeper with it, the earth shakes, and you loose the perl. You can't carry more than one perl. There is nothing intersting in the house.

// IMAGE

Now let's identify what we can easily mess with in the game data. There are some interesting JSON files in the data folder.

If you take a look at `MapInfos.json`, you'll see that there are three indexed maps. Among them a map called "flag_map".

```json
[
null,
{"id":1,"expanded":true,"name":"MAP001","order":1,"parentId":0,"scrollX":1139,"scrollY":663.5},
{"id":2,"expanded":false,"name":"flag_map","order":2,"parentId":1,"scrollX":1131,"scrollY":655.5},
{"id":3,"expanded":false,"name":"interior","order":3,"parentId":1,"scrollX":1139,"scrollY":641}
]
```

You also can access the details of each map in the fils "Map001.json", "Map002.json" and "Map003.json". Each map has some basic informations, like names, ids, etc. It also contains a list of all events present on that map. An event is some dynamic action the game creator can script.

Finally, the "System.json" file contains some general informations about the game.

The different approaches I could think of are : create an event of our own to teleport to the wanted map, modify the "keeper" event to be able to get passed the keeper without having the perl, change the default spawning position, get two perls instead of one in the chest, remove the earth_quake event, ...

There are basically endless possibilities, but I am going to highlight two easy ones.

First, let's remove the earth_quake event. Juste delete the line 7 in "Map001.json", and rerun the game. You won't loose the perl, and you can get passed the keeper.

Second easy way is to change the default spawn. In the "System.json" file, change look for the `startMapId` parameter (carefull, there are 4 total, with 3 of them set to 0, there unused game features). It sould look like this `"startMapId":1,"startX":6,"startY":6`. We established that the index of the map with the flag is 2, so let's change the `startMapId` to 2 : `"startMapId":2,"startX":6,"startY":6` and the game again !

In any case, the final step is to look for flag. The "Map002.json" file teaches us that the map is sized 100x100 : `[...], "height":100, [...], "width":100, [...]`. Let's walk to the end.

Congratz !

// IMAGE

/!\ Don't forget to empty your cache each time you modify game data, or the changes won't take effect ;)

### Flag

```HERO{RPG_CR4CK3D}```
