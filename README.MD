# Multi-tenant Feature Flags

This is a project with management of feature flags for multi-driver applications.

## Requisitos

- Docker 
- Docker Compose

## Instalación

1. Clona este repositorio: `git clone https://github.com/Talently-Oficial/feature-flags.git`
2. Navega al directorio del proyecto: `cd feature-flags`
3. Run the project: `docker-compose up -d`
4. inside the container run: `composer install --dev`
5. Run vendor/bin/phpunit to run the tests

## Uso

This is a library to be used in other projects.

composer require talently/feature-flags

## Contribución

The contributions are welcome. Please, follow these instructions to contribute to the project:

1. Make a fork of this repository.
2. Create a new branch: `git checkout -b new-branch-name`
3. Make your changes and commit to the new branch: `git commit -am 'Add new feature'`
4. Push your changes to your fork repository: `git push origin new-branch-name`
5. Send a pull request to the main branch of this repository.
6. Wait for the review and merge.

## Créditos

- [Talently](https://everest.talently.tech/)
- [Miguel Quevedo](https://github.com/leugin)
- [Emmanuel](https://github.com/emmanuelbarturen)
- [Miguel Moreno](https://github.com/mmorenoregalado)
- [Henry Vega](https://github.com/HenryVegaAyala)
## Licencia

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.