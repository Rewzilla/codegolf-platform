#include <stdlib.h>
#include <unistd.h>
#include <grp.h>

#define SU_UID 65534
#define SU_GID 65534

#define TIMEOUT "3"

int main(int argc, char *argv[]) {

	chroot(getenv("PWD"));

	setgroups(0, 0);

	setgid(SU_GID);
	setuid(SU_UID);

	execl("/usr/bin/timeout", "/usr/bin/timeout", "-s", "SIGKILL", TIMEOUT, argv[1], NULL);

}
