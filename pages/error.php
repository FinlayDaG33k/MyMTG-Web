<?php
class NoExtentionIterator extends FilesystemIterator {
	public function current() {
		return pathinfo(parent::current(), PATHINFO_FILENAME);
	}
	public function accept() {
		return parent::current()->isfile();
	}
	public function __toString() {
		return implode("\n", iterator_to_array($this));
	}
}

function levenshtein_iterator($array,$input){
	$shortest = -1;
	foreach ($array as $item) {
	  // calculate the distance between the input word,
	  // and the current word
	  $lev = levenshtein($input, $item);
	  // check for an exact match
	  if ($lev == 0) {
	    // closest word is this one (exact match)
	    $closest = $item;
	    $shortest = 0;
	    // break out of the loop; we've found an exact match!
	    break;
	  }

	  // if this distance is less than the next found shortest
	  // distance, OR if a next shortest word has not yet been found
	  if ($lev <= $shortest || $shortest < 0) {
	    // set the closest match, and shortest distance
	    $closest  = $item;
	    $shortest = $lev;
	  }
	}
	return array("closest" => $closest,"shortest" => $shortest);
}

$levenshtein = levenshtein_iterator(explode("\n",new NoExtentionIterator("pages")),$_GET['page']);
?>
<div class="alert alert-danger">
  <strong>Page not found!</strong><br />
	We could not find the page you tried to visit.<br />
	Did you mean <a href="/<?= htmlentities($levenshtein['closest']); ?>"><u><?= htmlentities(ucfirst($levenshtein['closest'])); ?></u></a>?
</div>
