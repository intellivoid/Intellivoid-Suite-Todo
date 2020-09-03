clean:
	rm -rf build

build:
	mkdir build
	ppm --no-intro --compile="src/Todo" --directory="build"

update:
	ppm --generate-package="src/Todo"

install:
	ppm --no-prompt --fix-conflict --install="build/net.intellivoid.todo.ppm"