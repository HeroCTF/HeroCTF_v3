import numpy as np
import cv2
import sys

def unscramble(image):
    # The most crucial step, you don't flag if you don't set the seed.
    np.random.seed(420)

    # Image dimensions : 1280x720
    # Load the image
    hidden = cv2.imread(image)
    hidden = cv2.cvtColor(hidden, cv2.COLOR_BGR2GRAY)
    # Create an empty canvas
    result = np.zeros((720, 1280))
    # So that we can follow the scrambling, just create a range array
    # Example : np.arange(0, 10, 1) => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
    # Don't forget we're on grayscale right here, so 2D array only.
    # (I'm nice right ?)
    range_array = np.zeros((720, 1280))

    # Effectively create an arange on multiple lines 
    # The array will look like this

    # [[0, 1, 2, 3, 4 ...],
    #  [0, 1, 2, 3, 4 ...],
    #  [0, 1, 2, 3, 4 ...],
    #         ....
    #  [0, 1, 2, 3, 4 ...]]

    for i in range(720):
        range_array[i] = np.arange(0, 1280, 1)
  
    # Shuffle it the exact same way as the input image
    # Then you can just sort the numbers !
    for i in range(range_array.shape[0]):
        np.random.shuffle(range_array[i])

    # A bit complicated, but here, we iterate over the image, and the range array we just created line by line.
    # By sorting the range array, we can retrieve the order of the pixels in the hidden image.
    for i in range(720):
        result[i] = [x for _, x in sorted(zip(range_array[i], hidden[i]))]

    # Save the flag to flag.jpg file
    cv2.imwrite('flag.jpg', result)

unscramble('challenge.jpg')

# Hero{S3eD3d_Scr4Mbl3}