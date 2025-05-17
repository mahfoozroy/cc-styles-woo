const path = require('path');
const execa = require('execa');
const chalk = require('chalk');

const PLUGIN_DIR = path.resolve(__dirname);
const PHPCS_STANDARD = 'WordPress';

async function runLinting() {
	console.log(chalk.cyan('🔍 Running PHP Lint and WP Coding Standards...'));

	// PHP syntax check
	try {
		await execa.command(`find ${PLUGIN_DIR} -name '*.php' -exec php -l {} \\;`);
		console.log(chalk.green('PHP syntax check passed'));
	} catch (err) {
		console.error(chalk.red('❌ PHP syntax errors found:\n'), err.stdout || err);
		process.exit(1);
	}

	// PHPCS check
	try {
		await execa.command(`phpcs --standard=${PHPCS_STANDARD} ${PLUGIN_DIR}`);
		console.log(chalk.green('PHPCS passed'));
	} catch (err) {
		console.error(chalk.red('❌ PHPCS errors found:\n'), err.stdout || err);
		process.exit(1);
	}
}

module.exports = { runLinting };
