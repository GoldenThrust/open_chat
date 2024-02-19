import sys

num = int(sys.argv[1])


def recurse(pos):
    k = 1
    for j in reversed(range(pos[0])):
        if ([j, pos[1]] in queen_pos or [j, pos[1] - k] in queen_pos or [j, pos[1] + k] in queen_pos):
            pos[1] += 1
            recurse(pos)
        else:
            if pos[1] >= num:
                return
            if pos not in queen_pos and j == 0:
                if not queen_pos[-1][0] == pos[0] - 1:
                    return
                queen_pos.append(pos)

        k += 1

for i in range(1, num - 1):
    arr = [[0 for _ in range(num)] for _ in range(num)]

    queen_pos = [[0, i]]
    for i in range(1, num):
        pos = [i, 0]
        recurse(pos)

    print(queen_pos)

    for i in queen_pos:
        arr[i[0]][i[1]] = 1

    for i in arr:
        print(i)