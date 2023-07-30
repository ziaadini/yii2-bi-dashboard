## Routes

The bidashboard project includes several routes that serve different purposes. Here's an overview of each route and what
it does:

- `/bidashboard/report-widget`:
    - Purpose: This route displays widgets on the dashboard. Widgets are small, self-contained data visualizations or
      components that provide a quick overview of key metrics.

- `/bidashboard/report-page`:
    - Purpose: This route is responsible for displaying the widgets' information on the report pages of the bidashboard.
      Each page can be categorized as either daily or monthly, and the displayed information varies based on this
      categorization. Monthly pages show information for each of the 30 days of the month, while annual pages show the
      aggregated information for the entire year. Additionally, there are filters available above the page display that
      allow users to access information from different years or months. Users can also add widgets to the page, ensuring
      that the type of widget aligns with the page's categorization (daily or monthly).
    - Description: The Report Page of the bidashboard provides a customizable view where users can arrange widgets and
      visualize data specific to each page's categorization. Users can create monthly or annual pages, and based on the
      selected page type, the widgets will display data accordingly. The filters above the page display enable users to
      narrow down the view to a specific year or month, offering more granular control over the data displayed.
      Furthermore, users can add widgets of the appropriate type (daily or monthly) to the page, ensuring that the
      content is relevant and meaningful.
    - CRUD Operations:
        - Create: Users can create new report pages, specifying whether the page is daily or monthly.
        - Read: The route retrieves and displays existing report pages, showing the appropriate widgets and data
          based on the categorization (daily or monthly) and selected filters (year or month).
        - Update: Users can update the name of existing report pages
        - Delete: Users can delete report pages that are no longer needed or relevant.
- `/bidashboard/report-year`:
    - Purpose: This route is responsible for handling the creation of years for use in the Select2 input field, which is
      located on the View Report Page of the bidashboard.
    - Description: On the View Report Page, there is a Select2 input field that allows users to choose specific years
      for their report. When users interact with this input field, the route `/bidashboard/report-year` is called to
      fetch the list of available years. The route retrieves the necessary data and returns it in a format suitable for
      populating the Select2 dropdown with the list of selectable years.

- `/bidashboard/sharing-page`:
    - Purpose: This route is responsible for managing the sharing settings and permissions for specific pages in the
      bidashboard. It allows users with appropriate privileges to control who is allowed to access the desired page and
      how long that access is valid.
    - Description: On the Sharing Page, users can specify access rights and permissions for individual pages within the
      bidashboard. These permissions determine which users or user groups have access to view or interact with specific
      pages. Additionally, users can set the validity period for the shared access, allowing them to control the
      duration during which shared access remains active.