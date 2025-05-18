const fs = require('fs');
const path = require('path');
const execa = require('execa');
const chalk = require('chalk');

const PLUGIN_DIR = path.resolve(__dirname);
const PHPCS_STANDARD = 'WordPress';

async function runLinting() {
	console.log(chalk.cyan('🔍 Running PHP Lint and WP Coding Standards...'));

	console.log(chalk.cyan('🔍 Running PHP lint on all files...'));

	const phpFiles = await getPhpFiles(PLUGIN_DIR);

	let hasError = false;

	for (const file of phpFiles) {
		try {
			await execa('php', ['-l', file]);
		} catch (err) {
			console.error(chalk.red(`❌ PHP syntax error in: ${file}`));
			console.error(err.stdout || err.message);
			hasError = true;
		}
	}

	if (hasError) {
		console.log(chalk.red('💥 PHP linting failed.'));
		process.exit(1);
	} else {
		console.log(chalk.green('✅ PHP syntax check passed.'));
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
async function getPhpFiles(dir) {
	const files = await fs.promises.readdir(dir, { withFileTypes: true });
	let phpFiles = [];

	for (const file of files) {
		const fullPath = path.join(dir, file.name);

		if (file.isDirectory()) {
			const nested = await getPhpFiles(fullPath);
			phpFiles = phpFiles.concat(nested);
		} else if (file.name.endsWith('.php')) {
			phpFiles.push(fullPath);
		}
	}

	return phpFiles;
}
module.exports = { runLinting };
