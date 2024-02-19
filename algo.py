pos = [3, 1]

arr = [[0, 0, 0, 0],
        [0, 0, 0, 0],
        [0, 0, 0, 0],
        [0, 0, 0, 0]]

arr[pos[0]][pos[1]] = 1
j = 1
for i in reversed(range(pos[0])):
    arr[i][pos[1]] = 1
    print('x', i, pos[1])
    if pos[1] - j >= 0:
        arr[i][pos[1] - j] = 1
        print('d1', i, pos[1] - j)
    if pos[1] + j < len(arr):
        print('d2', i, pos[1] + j) 
        arr[i][pos[1] + j] = 1

    j += 1

for i in arr:
    print(i)