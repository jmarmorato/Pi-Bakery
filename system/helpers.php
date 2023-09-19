<?php

function parent_filter($e) {
	if ($e != "." && $e != "..") {
		return true;
	}
}