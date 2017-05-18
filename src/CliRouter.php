<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Console;

use Kdyby;
use Nette;
use Nette\Application\Request;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class CliRouter extends Nette\Object implements Nette\Application\IRouter
{

	/**
	 * @var array
	 */
	public $allowedMethods = ['cli'];

	/**
	 * @var \Nette\DI\Container
	 */
	private $container;

	/**
	 * @var InputInterface
	 */
	private $input;

	/**
	 * @var OutputInterface
	 */
	private $output;



	/**
	 * @param \Nette\DI\Container $container
	 */
	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}



	/**
	 * @param OutputInterface $output
	 */
	public function setOutput(OutputInterface $output)
	{
		$this->output = $output;
	}



	/**
	 * @param InputInterface $input
	 */
	public function setInput(InputInterface $input)
	{
		$this->input = $input;
	}



	/**
	 * Maps HTTP request to a Request object.
	 */
	public function match(Nette\Http\IRequest $httpRequest)
	{
		if (!in_array(PHP_SAPI, $this->allowedMethods, TRUE)) {
			return NULL;
		}

		if (empty($_SERVER['argv']) || !is_array($_SERVER['argv'])) {
			return NULL;
		}

		if (($input = $this->input) === NULL) {
			$input = new ArgvInput();
		}

		if (($output = $this->output) === NULL) {
			$output = new ConsoleOutput();
		}

		return new Request('Kdyby:Cli', 'cli', [
			'action' => 'default',
			'input' => $input,
			'output' => $output,
		]);
	}



	/**
	 * Constructs absolute URL from Request object.
	 */
	public function constructUrl(Request $appRequest, Nette\Http\Url $refUrl)
	{
		return NULL;
	}

}
