shift
=====

Leaves system

Create a system for requesting/approving/tracking user Leaves. Users request a Leave through the system. Leave requests are to be approved/rejected by management.

Each Leave has a type, and each Leave type is named and defined by multiple rules. See the list of basic rules below. Rules can be used to check Leave (check maximum days for user), modify it (auto approve) or just act as an option (paid). Some rules are checked/applied on both request and approval, and some only on approval.

In addition, holidays can be defined in system. They are taken into account depending on "exclude holidays" rule.

Notes:
Rule system must be extendable.
For database use MySQL or MongoDB.
Use OOP and utilize any open-source frameworks/libraries.
You will make heavy use of Date range comparisons. Assume those functionalities are implemented (just create an interface for them). Implement them for bonus points.

Leave definition:
User Id (int)
Leave Type Id (int)
Start (timestamp)
End (timestamp)
Note (string)
Approved (bool)

Holiday definition:
Name (string)
Start (timestamp)
End (timestamp)

Basic rules to implement (with arguments):
Require end (Y/N) - Is end date field required?
Auto approve (Y/N) - If Y, Leave request is automatically approved upon creation.
Paid (Y/N) - Is Leave paid?
Days allowed in month/year per user (number of days, month/year) - Has two options: 1. number of days, 2. period of time which can be month or year.
Exclude holidays (Y/N) - If Y, days of holiday should be subtracted from number of days.
Must be booked in advance (number of days) - User will not be able to request Leave less than specified number of days before it starts.
Maximum users allowed at the same time (number of users) - How many users can take Leave at the same time?
