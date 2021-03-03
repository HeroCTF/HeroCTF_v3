# JNI

### Category

Reverse

### Description

Find the flag in this android application.

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Files

- JNI.apk

### Write up

First, let's use `apktool` to extract the apk.

```shell
$ apktool d JNI.apk -o out
$ cd out/
$ ls
AndroidManifest.xml  apktool.yml  lib  original  res  smali
```

This app is very simple, there is only one activity named MainActivity. You can use JADX to recover the Java code but I will keep it in smali (more fun).

In the smali code of the MainActivity, we can see that the constructor loads a native C/C++ librairy named `native-lib` :

```smali
# direct methods
.method static constructor <clinit>()V
    .locals 1

    .line 18
    const-string v0, "native-lib"

    invoke-static {v0}, Ljava/lang/System;->loadLibrary(Ljava/lang/String;)V

    .line 19
    return-void
.end method
```

Now lets look at the submitFlag() function.

```
.method private submitFlag()V
    .locals 3

    .line 40
    iget-object v0, p0, Lfr/heroctf/jni/MainActivity;->flagEditText:Landroid/widget/EditText;

    invoke-virtual {v0}, Landroid/widget/EditText;->getText()Landroid/text/Editable;

    move-result-object v0

    invoke-virtual {v0}, Ljava/lang/Object;->toString()Ljava/lang/String;

    move-result-object v0

    # --- Store the content of an EditText in v0 ---

    .line 42
    .local v0, "inputText":Ljava/lang/String;
    invoke-virtual {p0, v0}, Lfr/heroctf/jni/MainActivity;->checkFlag(Ljava/lang/String;)Z

    # --- Run checkFlag on this string ---

    move-result v1

    const/4 v2, 0x0

    if-eqz v1, :cond_0 # --- if true -> win ---

    .line 43
    const-string v1, "You can validate the challenge with this flag !"

    invoke-static {p0, v1, v2}, Landroid/widget/Toast;->makeText(Landroid/content/Context;Ljava/lang/CharSequence;I)Landroid/widget/Toast;

    move-result-object v1

    .line 44
    invoke-virtual {v1}, Landroid/widget/Toast;->show()V

    goto :goto_0

    .line 46
    :cond_0 # --- if false -> lose ---
    const-string v1, "Wrong flag !"

    invoke-static {p0, v1, v2}, Landroid/widget/Toast;->makeText(Landroid/content/Context;Ljava/lang/CharSequence;I)Landroid/widget/Toast;

    move-result-object v1

    invoke-virtual {v1}, Landroid/widget/Toast;->show()V

    .line 48
    :goto_0
    return-void
.end method
```

We know that `checkFlag` is a native function thanks to this part of code :

```smali
# virtual methods
.method public native checkFlag(Ljava/lang/String;)Z
.end method
```

Let's look at the `native-lib` librairy in the `lib` folder.

```shell
cd lib/
$ tree
.
├── arm64-v8a
│   └── libnative-lib.so
├── armeabi-v7a
│   └── libnative-lib.so
├── x86
│   └── libnative-lib.so
└── x86_64
    └── libnative-lib.so

4 directories, 4 files
```

This librairy is compiled in multiple architectures. After decompiling one of those with Ghidra, you will have the following code :

```cpp
uint Java_fr_heroctf_jni_MainActivity_checkFlag
               (_JNIEnv *param_1,undefined4 param_2,_jstring *param_3)

{
  char *__s;
  size_t sVar1;
  byte local_29;
  uchar local_19;
  int local_18;
  
  local_18 = __stack_chk_guard;
  __s = (char *)GetStringUTFChars(param_1,param_3,&local_19);
  if ((((local_19 == '\x01') && (sVar1 = strlen(__s), sVar1 == 3)) && (*__s == '6')) &&
     ((__s[1] == '6' && (__s[2] == '6')))) {
    local_29 = 1;
  }
  else {
    local_29 = 0;
  }
  if (__stack_chk_guard != local_18) {
                    /* WARNING: Subroutine does not return */
    __stack_chk_fail();
  }
  return (uint)local_29;
}
```

`Java_fr_heroctf_jni_MainActivity_checkFlag` indicates the path to the MainActivity and the function name. We want `local_29` to 1, so the following conditionnal need to be true.

```cpp
  __s = (char *)GetStringUTFChars(param_1,param_3,&local_19);
  if ((((local_19 == '\x01') && (sVar1 = strlen(__s), sVar1 == 3)) && (*__s == '6')) &&
     ((__s[1] == '6' && (__s[2] == '6')))) {
    local_29 = 1;
  }
```

`local_19` is equals to 1 if the function GetStringUTFChars() has made a copy, it's just a check.

Then :
- len(sVar1) == 3
- sVar1[0] == '6'
- sVar1[1] == '6'
- sVar1[2] == '6'

We have our flag : 666. Do not hesitate to look at the [source code](src/) of the app to have a deeper understanding of how the app works.

### Flag

Hero{666}
