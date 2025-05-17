const fs = require('fs-extra');
const archiver = require('archiver');
const path = require('path');
const chalk = require('chalk');
const { runLinting } = require('./phplinter');



const PLUGIN_SLUG = 'woo-cc-styles';
const AOF_SOURCE = path.resolve(__dirname, '../awesome-options-framework'); // adjust if needed
const AOF_DEST = path.resolve(__dirname, 'inc/options');
const BUILD_DIR = path.resolve(__dirname, 'build');
const ZIP_FILE = path.join(BUILD_DIR, `${PLUGIN_SLUG}.zip`);

async function clean() {
	console.log(chalk.yellow('🧹 Cleaning old AOF...'));
	await fs.remove(AOF_DEST);
}

async function copyAOF() {
	console.log(chalk.blue('Copying Awesome Options Framework...'));
	await fs.copy(AOF_SOURCE, AOF_DEST, {
		filter: (src) => {
			const ignored = ['.git', '.DS_Store', 'node_modules', '.idea', '.gitignore' ];
			return !ignored.some((item) => src.includes(item));
		}
	});
}

async function createZip() {
	console.log(chalk.green('Creating plugin ZIP...'));

	await fs.ensureDir(BUILD_DIR);

	const output = fs.createWriteStream(ZIP_FILE);
	const archive = archiver('zip', {
		zlib: { level: 9 }
	});

	return new Promise((resolve, reject) => {
		output.on('close', () => {
			console.log(chalk.green(`Build complete: ${ZIP_FILE} (${archive.pointer()} bytes)`));
			resolve();
		});

		archive.on('error', (err) => reject(err));

		archive.pipe(output);

		archive.glob('**/*', {
			cwd: path.resolve(__dirname),
			ignore: [
				'build/**',
				'build.js',
				'package.json',
				'package-lock.json',
				'.git/**',
				'.idea/**',
				'.DS_Store',
                '.gitignore',
				'node_modules/**'
			]
		});

		archive.finalize();
	});
}
const simpleGit = require('simple-git');
const git = simpleGit(AOF_SOURCE);

async function updateAOFRepo() {
	console.log(chalk.cyan('🔄 Pulling latest Awesome Options Framework from GitHub...'));
	try {
		await git.fetch();
		await git.pull('origin', 'main'); 
	} catch (err) {
		console.error(chalk.red('Git pull failed:'), err);
	}
}


async function run() {
	try {
		await updateAOFRepo();
		await runLinting(); 
		await clean();
		await copyAOF();
		await createZip();
	} catch (err) {
		console.error(chalk.red('Build failed'), err);
		process.exit(1);
	}
}
run();
