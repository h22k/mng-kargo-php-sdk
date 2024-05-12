.PHONY: help
help:
	@sed -n 's/^##//p' ${MAKEFILE_LIST} | column -t -s ':' |  sed -e 's/^/ /'

## coverage-open: 🐘 Calculate the coverage, write it to html and open it. [Only works with UNIX systems.]
.PHONY: coverage-open
coverage-open:
	make coverage-html && open coverage-report/index.html

## coverage-html: 🧮 Calculate the coverage.
.PHONY: coverage-html
coverage-html:
	composer test:coverage-html

## sure: 📦 Make sure of code is fault free and ready to push 😗
.PHONY: sure
sure:
	composer test:coverage && composer phpstan && composer phpcs
