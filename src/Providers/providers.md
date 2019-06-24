# List of macros

## ChunkDynamicContent
This method retrieves a small chunk of the dynamic results at a time and feeds each chunk into a `Closure` for processing.
If you are updating database records while chunking results, your chunk results could change in unexpected ways.
This method will automatically include the result from query in the chunked results.

### Usage
For example, let's work with the entire users table in chunks of 100 records at a time:
```php
DB::table('users')->where('status_id', User::$ACCEPTED)->orderBy('id')->chunkDynamicContent(100, function ($users) {
    foreach ($users as $user) {
        $user->status_id = User::$DECLINED;
        $user->save();
    }
});
```
You may stop further chunks from being processed by returning `false` from the `Closure`.

