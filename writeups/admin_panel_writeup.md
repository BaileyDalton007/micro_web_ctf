# Admin Panel

Admin Panel is a simple web CTF were you are given a barebones interface that stores a flag.

![image](https://github.com/user-attachments/assets/f0fef303-37bc-4284-af9a-c6f76d501bfd)

It seems like we are currently logged in as a **guest** and need to somehow become **admin** to get the flag, according to the text.

A logical first step would be to input a new username to see what happens.

![image](https://github.com/user-attachments/assets/f2074ae4-94b1-462b-9e3b-09af50e5dd93)

We are now logged in with the username **bailey**, which seems simple enough. Let's try the same as **admin**.

![image](https://github.com/user-attachments/assets/1cdfd92d-4ab6-49ac-9ff6-9fd855b2eb7d)

We are now allowed to log in as **admin**. There must be some sort of validation that does not allow admin to be input into the text box.

However, we observed the URL change when we first changed our username. When we logged in as **bailey**, the URL became:

`http://eecslab-22.case.edu/~bmd81/ctf_challenges/admin_panel/panel.php?username=bailey`

The `username=bailey` is a parameter being passed to the PHP backend, let us try setting it ourselves by inputting:

`http://eecslab-22.case.edu/~bmd81/ctf_challenges/admin_panel/panel.php?username=admin`

![image](https://github.com/user-attachments/assets/1afa904e-4690-41d4-a3d7-69f62f3e84f9)

It worked!
