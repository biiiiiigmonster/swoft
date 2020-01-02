<?php
/**
 * The is a config file for compile phar package.
 * @var \Swoft\Console\Advanced\PharCompiler $compiler
 */

// config
$compiler
    // 删除代码注释。打包swoft 应用需要配合 setStripFilter()
    ->stripComments(true)
    ->setShebang(true)
    // 需要打包的文件后缀，内置已经包含了 .php
    ->addSuffix(['.tpl','.json','.stub'])
    // 排除打包目录，排除一些无用的目录，可以有效减少输出文件大小
    ->addExcludeDir([
        'test',
        'doc',
        'docs',
        'tests',
        'Tests',
        'example',
        'runtime',
        'swoole-ide-helper',
    ])
    // 指定添加的文件
    ->addFile([
        'LICENSE',
	'.env',
        'composer.json',
        'README.md',
        'bin/bootstrap.php',
    ])
    ->setCliIndex('bin/swoft') // 应用入口
    // ->setWebIndex('web/index.php')
    // ->setVersionFile('config/config.php')
;

// 那些目录需要去除注释。Swoft 相关都不能去除注释
$stripDirs = [
    'psr/',
    'nikic/',
    'monolog/',
    'symfony/',
    'toolkit/',
];

$compiler->setStripFilter(function ($file) use ($stripDirs) {
    /** @var \SplFileInfo $file */
    $path = $file->getPathname();

    foreach ($stripDirs as $dir) {
        if (\strpos($path, $dir)) {
            return true;
        }
    }

    return false;
});
