#include <jni.h>
#include <string>
#include <cmath>

using namespace std;

extern "C" JNIEXPORT jboolean JNICALL
Java_fr_heroctf_jni_MainActivity_checkFlag(
        JNIEnv* env,
        jobject obj,
        jstring inputText) {

    jboolean isCopy;
    const char* charsInput = env->GetStringUTFChars(inputText, &isCopy);
    if (isCopy == JNI_TRUE) {
        if (strlen(charsInput) == 3
            && charsInput[0] == '6'
            && charsInput[1] == '6'
            && charsInput[2] == '6'
            ) {
            return JNI_TRUE;
        }
    }
    return JNI_FALSE;
}