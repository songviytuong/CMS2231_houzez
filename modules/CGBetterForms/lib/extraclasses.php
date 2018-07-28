<?php
namespace CGBetterForms;

class Exception extends \Exception {}
class FormScannerError extends \RuntimeException {}    // admin side
class FormValidationError extends FormScannerError {}  // admin side
class BotDetectedError extends Exception {}  // frontend
class StopDispositionTrigger extends Exception {} // frontend
class ValidationError extends Exception {} // frontend
class DispositionError extends Exception {} // frontend
