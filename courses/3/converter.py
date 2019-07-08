
with open("sql", 'w') as w:
    for x in range(1,12):
        with open('hole' + str(x), 'r') as fp:
            w.write("INSERT INTO holes(course,number, description) VALUES('3','" + str(x) + "','")
            for y in fp.read().split('\n'):
                if len(y) > 0 and y[0] == '=':
                    w.write('<hr style="border:2px dashed #000;">')
                else:
                    w.write(y + '<br>')
            w.write("');\n\n")


