# GitHub User Activity CLI with PHP

This simple program outputs user activity using GitHub public API based on username. Summarizes events by type and repository

Example

```bash
$ php github-activity.php oscar-fong

Output:
- Opened issue in oscar-fong/github-activity: "Test Issue"
- Created discussion in oscar-fong/github-activity: "Test"
- Created branch oscar-fong/github-activity
- Created branch oscar-fong/task-tracker
- Pushed 6 commits to oscar-fong/task-tracker
- Deleted branch oscar-fong/task-tracker
```

With this project I learned:

- HTTP/HTTPS requests, methods, headers and bodies
- How to consume a public API and read its documentation to follow syntax and format specification
- Transform HTTP bodies into readable and flexible data (an Array) to filter, process and lookup fields and data.
- Use loops to iterate over data.

