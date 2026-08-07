<h1>Debug: You found me!</h1>
<pre>
    {{ print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5), true) }}
</pre>
