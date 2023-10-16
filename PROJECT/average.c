#include <stdio.h>

int main() {
    int total = 0;
    float average;
    int i, score;

    for (i = 1; i <= 10; i++) {
        printf("Enter the score for subject %d: ", i);
        scanf("%d", &score);
        total += score;
    }

    average = (float)total / 10;

    printf("Total score: %d\n", total);
    printf("Average score: %.2f\n", average);

    return 0;
}
