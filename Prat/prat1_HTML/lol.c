#include <stdio.h>
#include <stdlib.h>
 
int main()
{
    int a = 5;
 
    int* int_pointer;    // an integer pointer
    float* float_pointer;  //a float pointer
    char* char_pointer;   //a character pointer
 
    printf("size of an int pointer =  %lu\n", sizeof(int_pointer));
    printf("size of an float pointer =  %lu\n", sizeof(float_pointer));
    printf("size of an char pointer =  %lu\n", sizeof(char_pointer));
 
    return 0;
}